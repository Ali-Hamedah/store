<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'store')->paginate(10);
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate(Product::rules($product->id));

        $product->update($request->except('tags'));

        $tags = json_decode($request->post('tags'));
        $tag_ids = [];

        $saved_tags = Tag::all();

        foreach ($tags as $item) {
            $slug = Str::slug($item->value);
            $tag = $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $item->value,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        $product->tags()->sync($tag_ids);

        return redirect()->route('dashboard.products.index', $product->id)->with('success', __('messages.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Request $request)
    {
        if ($request->page_id == 2) {
            $delete_select_id = explode(",", $request->delete_select_id);

            Product::destroy($delete_select_id);

            // $category->delete();
            return redirect()->route('dashboard.products.index')->with('success', __('messages.delete'));
        } else {
            // if (!empty($category->image) && Storage::disk('images')->exists($category->image)) {
            //     // حذف الصورة إذا كانت موجودة
            //     Storage::disk('images')->delete($category->image);
            // }
            $product->delete();
            return redirect()->route('dashboard.products.index')->with('success', 'Product deleted successfully');
        }
    }

    public function deleteSelected(Request $request)
    {

        if ($request->has('selected_items')) {
            Product::whereIn('id', $request->input('selected_items'))->delete();
            return redirect()->route('dashboard.categories.index')->with('success', 'تم حذف العناصر المحددة بنجاح.');
        }
        return redirect()->route('dashboard.categories.index')->with('error', 'لم يتم تحديد أي عنصر.');
    }
}
