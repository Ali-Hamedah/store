<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')->paginate(12);
        return view('front.product', compact('products'));
    }

    public function show(Product $product)
    {
        $product = Product::where('id',$product->id)->first();
        return view('front.products.show', compact('product'));
    }
}
