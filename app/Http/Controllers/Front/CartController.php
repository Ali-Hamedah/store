<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Product;
use App\Helpers\Currency;
use Illuminate\Http\Request;
use App\Models\ProductCoupon;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartModelRepository;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.cart', [
            'cart' => $this->cart,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'color_id' => ['required', 'exists:colors,id'],
            'size_id' => ['required', 'exists:sizes,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $productVariant = ProductVariant::where('product_id', $validatedData['product_id'])
            ->where('color_id', $validatedData['color_id'])
            ->where('size_id', $validatedData['size_id'])
            ->first();

        if (!$productVariant) {
            return redirect()->back()->withErrors(['variant' => 'The selected variant is not available.']);
        }

        // استدعاء دالة add
        $this->cart->add($productVariant, $validatedData['quantity'], $validatedData['color_id'], $validatedData['size_id']);


        return redirect()->back()->with('success', __('messages.add'));
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'int', 'min:1'],
        ]);

        $cartItem = Cart::find($id);

        $variant = $cartItem->product->variants->first();

        if ($request->quantity > $variant->quantity) {
            return response()->json([
                'error' => __('frontend.quantity_not_available'),
            ], 400);
        }
        $this->cart->update($id, $request->post('quantity'));

        $subtotal = $cartItem->quantity * $cartItem->product->price;

        $total = Cart::all()->sum(fn($item) => $item->quantity * $item->product->price);

        return response()->json([
            'subtotal' => Currency::format($subtotal),
            'total' => Currency::format($total),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cart->delete($id);
        $total = Cart::all()->sum(fn($item) => $item->quantity * $item->product->price);

        return [
            'message' => 'Item deleted!',
            'total' => \App\Helpers\Currency::format($total),
        ];
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $code = $request->input('coupon_code');

        $coupon = ProductCoupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'error_type' => 'invalid',
            ], 400);
        }

        if (!$coupon->canBeUsed()) {
            return response()->json([
                'error_type' => 'expired',
            ], 400);
        }


        $cartTotal = $this->cart->total();
        $greaterThan =  Currency::format($coupon->greater_than);

        $discount = $coupon->discount($cartTotal);
        $newTotal = $cartTotal - $discount;

        $formattedCartTotal = Currency::format($cartTotal);
        $formattedNewTotal = Currency::format($newTotal);
        $formattedDiscount = Currency::format($discount);

        session([
            'coupon_code' => $code,
            'formatted_discount' => $formattedDiscount,
            'formatted_cart_total' => $formattedCartTotal,
            'formatted_new_total' => $formattedNewTotal,
        ]);

        $coupon->increment('used_times');

        return response()->json([
            'success' => true,
            'message' => __('frontend.coupon_success'),
            'formatted_discount' => $formattedDiscount,
            'greater_than' => $greaterThan,
            'formatted_new_total' => $formattedNewTotal, 
        ]);
    }
}
