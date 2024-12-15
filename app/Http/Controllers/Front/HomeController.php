<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $favorites = Cache::remember('favorites_products', now()->addMinutes(10), function () {
            return Product::favorite()
                ->with('variants', 'firstMedia', 'category', 'reviews')
                ->inRandomOrder()
                ->latest()
                ->limit(8)
                ->get();
        });
        
        $newProducts = Cache::remember('new_products', now()->addMinutes(10), function () {
            return Product::new()
                ->with('variants', 'firstMedia', 'category')
                ->latest()
                ->limit(8)
                ->get();
        });
        
        $discounts = Cache::remember('discounted_products', now()->addMinutes(10), function () {
            return Product::discounted()
                ->with('variants', 'firstMedia', 'category', 'media')
                ->inRandomOrder()
                ->latest()
                ->limit(8)
                ->get();
        });
        
        $topRatedProducts = Cache::remember('top_rated_products', now()->addMinutes(10), function () {
            return Product::with('variants', 'media', 'category', 'reviews')
                ->withAvg('reviews', 'rating')
                ->orderBy('reviews_avg_rating', 'desc')
                ->take(3)
                ->get();
        });
        
        $bigOffer = Product::where('is_offer', 1)->orderBy('updated_at','desc')->first();
    
        return view('front.home', compact('favorites', 'newProducts', 'discounts', 'topRatedProducts', 'bigOffer'));
    }

    
}
