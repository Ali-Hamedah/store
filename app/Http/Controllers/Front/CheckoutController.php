<?php

namespace App\Http\Controllers\Front;

use Throwable;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Models\ProductCoupon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\Intl\Countries;
use App\Exceptions\InvalidOrderException;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Validator;
use App\Notifications\OrderCreatedNotification;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
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
            
            foreach ($items as $store_id => $cart_items) {
                // حساب إجمالي الخصم والمنتجات
                foreach ($cart_items as $item) {
                    $product = Product::findOrFail($item->product_id);
            
                    if ($product->price != $item->product->price) {
                        throw new \Exception("Product price has changed. Please refresh your cart.");
                    }
            
                    // حساب السعر قبل الخصم
                    $originalPrice = $product->price * $item->quantity;
            
                    // تحديث إجمالي السعر قبل الخصم
                    $totalBeforeDiscount += $originalPrice;
            
                    // إضافة المنتج إلى قائمة المنتجات
                    $productDiscounts[] = [
                        'product_id' => $item->product_id,
                        'original_price' => $originalPrice,
                        'quantity' => $item->quantity,
                        'product' => $product,
                    ];
                }
            
                // حساب الخصم الإجمالي على السلة
                $productDiscount = 0;
                if ($request->has('coupon_code') && $request->input('coupon_code')) {
                    $coupon = ProductCoupon::where('code', $request->input('coupon_code'))->first();
            
                    if (!$coupon) {
                        throw new \Exception("The coupon code is invalid.");
                    }
            
                    if (!$coupon->canBeUsed()) {
                        throw new \Exception("The coupon has expired or has been fully used.");
                    }
            
                    // حساب الخصم الإجمالي
                    $productDiscount = $coupon->calculateDiscount($totalBeforeDiscount); // استخدام الدالة لحساب الخصم الإجمالي
                }
            
                // توزيع الخصم بين المنتجات
                $totalAfterDiscount = 0;
                $totalDiscount = 0;
            
                foreach ($productDiscounts as $discountData) {
                    $productDiscountShare = ($discountData['original_price'] / $totalBeforeDiscount) * $productDiscount;
                    $totalDiscount += $productDiscountShare;
            
                    // حساب السعر بعد الخصم لكل منتج
                    $discountedPrice = $discountData['original_price'] - $productDiscountShare;
            
                    $totalAfterDiscount += $discountedPrice;
                }
            
                // إنشاء الطلب
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                    'total' => $totalAfterDiscount, // الإجمالي بعد الخصم
                    'total_before_discount' => $totalBeforeDiscount, // الإجمالي قبل الخصم
                    'discount' => $totalDiscount, // الخصم الإجمالي
                ]);
            
                // إضافة العناصر في الطلب
                foreach ($cart_items as $item) {
                    $product = Product::findOrFail($item->product_id);
                
                    // العثور على الخصم الموزع على هذا المنتج
                    $productDiscountShare = 0;
                    foreach ($productDiscounts as $discountData) {
                        if ($discountData['product_id'] == $item->product_id) {
                            // توزيع الخصم بناءً على الكمية
                            $productDiscountShare = ($discountData['original_price'] / $totalBeforeDiscount) * $productDiscount;
                            $productDiscountSharePerItem = $productDiscountShare / $item->quantity; // خصم لكل وحدة
                            break;
                        }
                    }
                
                    // إضافة العناصر إلى جدول OrderItem مع تخزين الخصم الموزع
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'original_price' => $item->product->price,
                        'discounted_price' => $item->product->price - $productDiscountSharePerItem, // السعر بعد الخصم للوحدة
                        'quantity' => $item->quantity,
                        // 'discount' => $productDiscountShare, // يمكن تخزين الخصم الكلي هنا إذا لزم الأمر
                    ]);
                }
            }
            
            // إضافة العناوين المرتبطة بالطلب
            foreach ($request->post('addr') as $type => $address) {
                $validatedAddress = Validator::make($address, [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255'],
                    'phone_number' => ['required', 'string', 'max:20'],
                    'city' => ['required', 'string', 'max:255'],
                ])->validate();
            
                $validatedAddress['type'] = $type;
                $order->addresses()->create($validatedAddress);
            }
            
            event(new OrderCreated($order));
            DB::commit();
           
    
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    
        return redirect()->route('cart.index');
    }
    
}
