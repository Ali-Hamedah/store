<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $favorites = Product::favorite()
    ->with('variants', 'media', 'category') // تحميل المتغيرات المرتبطة لتحسين الأداء
    ->latest() // ترتيب حسب الأحدث
    ->limit(8) // عرض 8 منتجات فقط
    ->get();
    $newProducts = Product::new()
    ->with('variants', 'media')
    ->latest()
    ->limit(8)
    ->get();
    $discounts = Product::discounted()
    ->with('variants', 'media')
    ->latest()
    ->limit(8)
    ->get();

        return view('front.home', compact('favorites', 'newProducts', 'discounts'));
    }
}
