<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active') // المنتجات النشطة فقط
        ->whereHas('variants', function ($query) { // التحقق من وجود المتغيرات
            $query->where('quantity', '>', 0); // الكمية أكبر من 0
        })
        ->with('variants') // لتحميل المتغيرات المرتبطة بالمنتج
        ->latest() // ترتيب المنتجات حسب الأحدث
        ->limit(8) // الحد الأقصى لعدد المنتجات المعروضة
        ->get();
    
        return view('front.home', compact('products'));
    }
}
