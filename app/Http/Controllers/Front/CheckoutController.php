<?php

namespace App\Http\Controllers\Front;

use Throwable;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Helpers\Currency;
use App\Models\OrderItem;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Models\ProductCoupon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Intl\Countries;
use Illuminate\Support\Facades\Session;
use App\Exceptions\InvalidOrderException;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Validator;
use App\Notifications\OrderCreatedNotification;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart, Request $request)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }
        $formatted_cart_total = session('formatted_cart_total'); // إجمالي المشتريات بتنسيق العملة
        $formatted_new_total = session('formatted_new_total'); // المجموع النهائي بعد الخصم بتنسيق العملة
        $formatted_discount = session('formatted_discount');
        $couponCode = session('coupon_code');
        if (Currency::format($cart->total()) !== $formatted_cart_total){
        //  dd($formatted_cart_total, Currency::format($cart->total()));
         return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
            
        ]);
    }
        // dd( $total, $couponCode);
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
            'cart_total' => $formatted_cart_total,
            'total' => $formatted_new_total,
            'discount' => $formatted_discount,
            'couponCode' => $couponCode,
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'addr.billing.first_name' => ['required', 'string', 'max:255'],
            'addr.billing.last_name' => ['required', 'string', 'max:255'],
            'addr.billing.email' => ['required', 'email', 'max:255'],
            'addr.billing.phone_number' => ['required', 'string', 'max:20'],
            'addr.billing.city' => ['required', 'string', 'max:255'],
        ]);

        $items = $cart->get()->groupBy('product.store_id')->all();
        DB::beginTransaction();

        try {
            $totalBeforeDiscount = 0;
            $totalAfterDiscount = 0;
            $totalDiscount = 0;
            $productDiscounts = [];


            $currencyCode = Session::get('currency_code', config('app.currency'));
            $cacheKey = 'currency_rate_' . $currencyCode;
            $rate = Cache::get($cacheKey, 1);

            if ($rate === 1) {

                try {
                    $converter = app('currency.converter');
                    $rate = $converter->convert(config('app.currency'), $currencyCode);
                    Cache::put($cacheKey, $rate, now()->addMinutes(360));
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['error' => 'Error fetching currency rate: ' . $e->getMessage()]);
                }
            }

            foreach ($items as $store_id => $cart_items) {

                foreach ($cart_items as $item) {
                    $product = Product::findOrFail($item->product_id);

                    if ($product->price != $item->product->price) {
                        throw new \Exception("Product price has changed. Please refresh your cart.");
                    }

                    $originalPrice = $product->price * $item->quantity;
                    $totalBeforeDiscount += $originalPrice;

                    $productDiscounts[] = [
                        'product_id' => $item->product_id,
                        'original_price' => $originalPrice,
                        'quantity' => $item->quantity,
                        'product' => $product,
                    ];
                }

                $productDiscount = 0;

                if ($request->has('coupon_code') && $request->input('coupon_code')) {
                    $coupon = ProductCoupon::where('code', $request->input('coupon_code'))->first();

                    if (!$coupon) {
                        throw new \Exception("The coupon code is invalid.");
                    }

                    if (!$coupon->canBeUsed()) {
                        throw new \Exception("The coupon has expired or has been fully used.");
                    }

                    $totalBeforeDiscountInNewCurrency = $coupon->discount($totalBeforeDiscount);
                    $productDiscount = $totalBeforeDiscountInNewCurrency * $rate;
                }

                $totalAfterDiscount = 0;
                $totalDiscount = 0;

                foreach ($productDiscounts as $discountData) {

                    $productDiscountShare = ($discountData['original_price'] / $totalBeforeDiscount) * $productDiscount;
                    $totalDiscount += $productDiscountShare;

                    $discountedPrice = $discountData['original_price'] - $productDiscountShare;

                    $discountedPriceInNewCurrency = $discountedPrice * $rate;

                    $totalAfterDiscount += $discountedPriceInNewCurrency;
                }
                $totalBeforeDiscount = $totalBeforeDiscount * $rate;

                $totalAfterDiscount = $totalBeforeDiscount - $totalDiscount;

                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                    'total_before_discount' => $totalBeforeDiscount,
                    'discount' => $totalDiscount,
                    'total' => $totalAfterDiscount,
                    'currency_code' => $currencyCode,
                ]);

                foreach ($cart_items as $item) {

                    $product = Product::find($item->product_id);
                    if (!$product) {
                        continue;
                    }

                    $productDiscountShare = 0;
                    foreach ($productDiscounts as $discountData) {
                        if ($discountData['product_id'] == $item->product_id) {
                            $productDiscountShare = ($discountData['original_price'] / $totalBeforeDiscount) * $productDiscount;
                            break;
                        }
                    }

                    $originalPriceInNewCurrency = $product->price * $rate;

                    $discountedPrice = ($product->price *  $item->quantity  - $productDiscountShare);

                    $discountedPriceInNewCurrencyTotal = $discountedPrice * $rate;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $product->name,
                        'original_price' => $originalPriceInNewCurrency, // السعر الأصلي بالعملة الجديدة
                        'discounted_price' => $discountedPriceInNewCurrencyTotal / $item->quantity, // السعر بعد الخصم بالعملة الجديدة
                        'total' => $discountedPriceInNewCurrencyTotal,
                        'quantity' => $item->quantity,
                    ]);
                }
            }

            foreach ($request->post('addr') as $type => $address) {
                $validatedAddress = Validator::make($address, [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255'],
                    'phone_number' => ['required', 'string', 'max:20'],
                    'city' => ['required', 'string', 'max:255'],
                ])->validate();

                $validatedAddress['type'] = $type;
                $validatedAddress['user_id'] = Auth::id(); // إضافة user_id بشكل صريح
                $order->addresses()->create($validatedAddress);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('cart.index');
    }
}
