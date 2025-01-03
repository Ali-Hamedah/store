<?php

namespace App\Http\Controllers\Front;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductReview;
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
            ->select('color_id')
            ->distinct()
            ->get();
        $sizes = $product->variants()->get();

        $userReview = $product->reviews->firstWhere('user_id', auth()->id());

        $reviewsInRange = $product->reviews->filter(function ($review) {
            return $review->rating >= 3 && $review->rating <= 5;
        })->shuffle();

        $otherReviews = $product->reviews->filter(function ($review) {
            return $review->rating < 3 || $review->rating > 5;
        });

        if ($userReview) {
            $reviews = collect([$userReview])->merge($reviewsInRange)->merge($otherReviews);
        } else {
            $reviews = $reviewsInRange->concat($otherReviews);
        }

        $reviews = $reviews->unique('id');

        $fiveStars = $reviews->where('rating', 5)->count();
        $fourStars = $reviews->where('rating', 4)->count();
        $threeStars = $reviews->where('rating', 3)->count();
        $twoStars = $reviews->where('rating', 2)->count();
        $oneStar = $reviews->where('rating', 1)->count();

        $averageRating = $reviews->avg('rating');

        return view('front.products.show', compact('product', 'colors', 'sizes', 'reviews', 'fiveStars', 'fourStars', 'threeStars', 'twoStars', 'oneStar', 'averageRating', 'userReview'));
    }

    public function getSizes(Request $request, $colorId)
    {   
        $sizesNames = ProductVariant::where('product_id', $request->product_id)
            ->where('color_id', $colorId)
            ->with('size') 
            ->get()
            ->map(function ($variant) {
                return [
                    'id' => $variant->size->id,
                    'name' => $variant->size->name,
                    'quantity' => $variant->quantity, 
                ];
            }); 
        return response()->json($sizesNames); 
    }

    public function shop($slug = null)
    {
        $search = request()->query('search', null);

        if ($search) {
            $products = Product::where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->paginate(12);

            return view('front.shop', ['products' => $products]);
        }

        if ($slug) {
            $category = Cache::remember("category_{$slug}", now()->addMinutes(10), function () use ($slug) {
                return Category::with('products')->where('slug', $slug)->first();
            });

            if ($category) {
                return view('front.shop', ['category' => $category, 'slug' => $slug]);
            }

            $tag = Cache::remember("tag_{$slug}", now()->addMinutes(10), function () use ($slug) {
                return Tag::with('products')->where('slug', $slug)->first();
            });

            if ($tag) {
                return view('front.shop', ['tag' => $tag, 'slug' => $slug]);
            }

            return redirect()->route('frontend.shop');
        } else {
            $categories = Cache::remember('categories_paginated', now()->addMinutes(10), function () {
                return Category::with('products')->paginate(12);
            });

            return view('front.shop', ['categories' => $categories]);
        }
    }

    public function addReview(Request $request)
    {

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'message' => 'required|string',
                'product_id' => 'required|exists:products,id',
            ]);

            $userId = auth()->id();

            $existingReview = ProductReview::where('user_id', $userId)
                ->where('product_id', $validated['product_id'])
                ->first();

            if ($existingReview) {
                return redirect()->back()->with('error', 'You have already reviewed this product.');
            }

            $review = new ProductReview();
            $review->title = $validated['title'];
            $review->rating = $validated['rating'];
            $review->message = $validated['message'];
            $review->user_id = $userId;
            $review->email = auth()->user()->email;
            $review->name = auth()->user()->name;
            $review->product_id = $validated['product_id'];
            $review->save();

            $review->save();

            return redirect()->back()->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('success', 'Review submitted falled!');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');

        $products = Product::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->when($category, function ($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->paginate(12);

        return view('front.shop', [
            'products' => $products,
            'query' => $query,
            'category' => $category,
        ]);
    }
}
