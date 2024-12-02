<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    public function create(Product $product)
    {
        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        $categories = Category::whereNull('parent_id')->whereStatus('active')->pluck('name', 'id');
        $subCategories = collect();
        $sizes = Size::orderBy('name', 'desc')->get();
        $colors = Color::orderBy('name', 'desc')->get();


        return view('dashboard.products.create', compact('product', 'tags', 'categories', 'subCategories', 'sizes', 'colors'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
    
        // التحقق من صحة البيانات
        $request->validate(Category::rules($request->id ?? null));
    
        // إعداد البيانات
        $categoryName = Str::slug($request->name, '-');
        $data = $request->except(['tags', 'category_id', 'image', 'sizes', 'colors', 'quantities']);
        $data['slug'] = $categoryName;
        $data['category_id'] = $request->sub_category;
        $data['store_id'] = 1;
    
        // حفظ المنتج الرئيسي
        $product = Product::create($data);
    
        // حفظ خصائص المنتج (الألوان، الأحجام، والكميات)
        foreach ($request->sizes as $index => $size) {
            $variant = new ProductVariant();
            $variant->product_id = $product->id; // استخدام معرف المنتج الرئيسي
            $variant->size_id = $size;
            $variant->color_id = $request->colors[$index];
            $variant->quantity = $request->quantities[$index];
            $variant->sku = Str::uuid()->toString();
            $variant->save();
        }
    
        // حفظ الصور
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $fileName = $categoryName . '-' . time() . '-' . uniqid() . '.' . $extension;
                $imagePath = $image->storeAs('products', $fileName, 'images');
                $imagePaths[] = $imagePath;
            }
            $product->update(['image' => json_encode($imagePaths)]); // تخزين المسارات في قاعدة البيانات
        }
    
        // حفظ العلامات (Tags)
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
    
        // تحديث كود المنتج
        $product->update(['product_code' => $product->id]);
    
        return redirect()->route('dashboard.products.index')->with('success', 'تم إنشاء المنتج بنجاح!');
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
        // تحويل التاجات إلى سلسلة نصية
        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        // جلب الأقسام الأساسية (الأم)
        $categories = Category::whereNull('parent_id')->pluck('name', 'id'); // جلب القسم الفرعي الذي ينتمي إليه المنتج
        $category = $product->category; // القسم الأساسي للمنتج

        // جلب الأقسام الفرعية بناءً على القسم الأساسي
        $subCategories = $category->parent_id ? Category::where('parent_id', $category->parent_id)->get() : collect();

        // إذا كان القسم الفرعي موجوداً، نحاول تحديد القسم الأساسي
        $parentCategory = $category->parent_id ? Category::find($category->parent_id) : null;

        return view('dashboard.products.edit', compact('product', 'tags', 'categories', 'subCategories', 'parentCategory'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate(Product::rules($product->id));

        $product->update($request->except('tags', 'category_id', 'image'));
        if ($request->has('sub_category') && $request->sub_category) {
            $product->update([
                'category_id' => $request->sub_category,
            ]);
        }

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

        if ($request->hasFile('image')) {
            if (!empty($product->image) && Storage::disk('images')->exists($product->image)) {
                Storage::disk('images')->delete($product->image);
            }
            $fileName = Str::slug($request->name, '-') . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $data['image'] = $request->file('image')->storeAs('products', $fileName, 'images');
            $product->update([
                'image' => $data['image'],
            ]);
        }


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

    public function getSubcategories($id)
    {
        $subcategories = Category::where('parent_id', $id)->pluck('name', 'id');
        return response()->json($subcategories);
    }
}
