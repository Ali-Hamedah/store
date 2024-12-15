<?php

namespace App\Http\Controllers\Front;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')->paginate(12);
        return view('front.product', compact('products'));
    }

    public function show(Product $product)
    {

        $product = Product::where('id', $product->id)->first();
        $colors = $product->variants()
    ->select('color_id') // حدد الأعمدة التي تريد جلبها
    ->distinct() // عدم تكرار القيم
    ->get();

        $sizes = $product->variants()->get();
        return view('front.products.show', compact('product', 'colors', 'sizes'));
    }

    public function getSizes(Request $request, $colorId)
    {
        // جلب المقاسات بناءً على المنتج واللون باستخدام العلاقة مع جدول "sizes"
        $sizesNames = ProductVariant::where('product_id', $request->product_id)
        ->where('color_id', $colorId)
        ->with('size') // تأكد من أنك قد قمت بتعريف العلاقة في نموذج "ProductVariant"
        ->get()
        ->pluck('size.name', 'size.id'); // سيعيد المصفوفة مع الـ ID كـ مفتاح والـ name كـ قيمة
     // جلب اسم المقاس فقط
    
        return response()->json($sizesNames); // إرسال البيانات بتنسيق JSON
    }
    
    public function shop($slug = null)
    {
        if ($slug) {
            $category = Cache::remember("category_{$slug}", now()->addMinutes(10), function () use ($slug) {
                return Category::with('products')->where('slug', $slug)->first();
            });
            if (!$category) {
                return redirect()->route('frontend.shop');
            }
            return view('front.shop', compact('category', 'slug'));
        } else {
            $categories = Cache::remember('categories_paginated', now()->addMinutes(10), function () {
                return Category::with('products')->paginate(12);
            });
            return view('front.shop', compact('categories'));
        }
        
    }
    

    public function shop_tag($slug = null)
    {
        return view('front.shop_tag', compact('slug'));
    }
    
    
    

}
