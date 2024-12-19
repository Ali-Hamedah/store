<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Product;
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
    
        $this->cart->update($id, $request->post('quantity'));
    
        // جلب العنصر المحدث من السلة
        $cartItem = Cart::find($id);
    
        // حساب المجموع الفرعي مباشرة
        $subtotal = $cartItem->quantity * $cartItem->product->price;
    
        // حساب المجموع الكلي (ديناميكيًا من العناصر في السلة)
        $total = Cart::all()->sum(fn($item) => $item->quantity * $item->product->price);
    
        // إرجاع الاستجابة كـ JSON
        return response()->json([
            'subtotal' => \App\Helpers\Currency::format($subtotal),
            'total' => \App\Helpers\Currency::format($total),
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
    
        // تحقق من وجود الكوبون
        $coupon = ProductCoupon::where('code', $code)->first();
    
        if (!$coupon) {
            return response()->json(['error' => 'الكوبون غير صالح.'], 400);
        }
    
        // تحقق من أن الكوبون يمكن استخدامه
        if (!$coupon->canBeUsed()) {
            return response()->json(['error' => 'الكوبون منتهي الصلاحية أو تم استخدامه بالكامل.'], 400);
        }
    
        // احصل على إجمالي السلة
        $cartTotal = $this->cart->total(); // تأكد أن لديك مكتبة Cart مفعلة
        $discount = $coupon->discount($cartTotal); // احسب الخصم
        $newTotal = $cartTotal - $discount;
    
        // تحديث عدد الاستخدامات
        $coupon->increment('used_times');
    
        return response()->json([
            'success' => true,
            'message' => 'تم تطبيق الكوبون بنجاح.',
            'discount' => $discount,
            'new_total' => $newTotal,
        ]);
    }
    
    
    

}