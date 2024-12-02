<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function get() : Collection
    {
        if (!$this->items->count()) {
            $this->items = Cart::with('product')->get();
        }

        return $this->items;
    }

    public function add(ProductVariant $productVariant, $quantity = 1, $color_id = null, $size_id = null)
    {
        if (!$color_id || !$size_id) {
            throw new \InvalidArgumentException('Color ID and Size ID are required.');
        }
    
        // تحقق من وجود المنتج المتغير
        $variant = ProductVariant::where('product_id', $productVariant->product_id)
            ->where('color_id', $color_id)
            ->where('size_id', $size_id)
            ->first();
    
        if (!$variant) {
            throw new \Exception('The selected product variant is not available.');
        }
    
        // البحث عن المنتج بنفس المواصفات (المنتج + اللون + المقاس) في السلة
        $existingCartItem = Cart::where('product_id', $productVariant->product_id)
            ->where('color_id', $color_id)
            ->where('size_id', $size_id)
            ->first();
  
        if ($existingCartItem) {
            // إذا كان المنتج بنفس المواصفات موجودًا، قم بزيادة العدد فقط
          
            $existingCartItem->increment('quantity', $quantity);
            return $existingCartItem;
        }
    
        // إذا لم يكن المنتج موجودًا بنفس المواصفات، قم بإضافته كعنصر جديد في السلة
        $cart = Cart::create([
            'id' => (string) Str::uuid(),
            'cookie_id' => request()->cookie('cart_cookie_id', (string) Str::uuid()),
            'user_id' => auth()->id(),
            'product_id' => $productVariant->product_id,
            'color_id' => $color_id,
            'size_id' => $size_id,
            'quantity' => $quantity,
            'options' => json_encode([]), // خيارات إضافية إذا لزم الأمر
        ]);
    
        return $cart;
    }
    

    public function update($id, $quantity)
    {
        $updated = Cart::where('id', '=', $id)
            ->update([
                'quantity' => $quantity,
            ]);
    
        // التحقق مما إذا تم التحديث بنجاح
        return $updated > 0;
    }
    

    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->delete();
    }

    public function empty()
    {
        Cart::query()->delete();
    }

    public function total() : float
    {
        /*return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total');*/

        return $this->get()->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
    }
}