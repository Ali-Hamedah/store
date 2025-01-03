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
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;



class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:view product|create product|edit product|delete product'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create product'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:update product'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete product'], ['only' => ['destroy']]);
    }


    public function index()
    {
        $products = Product::with('category', 'store', 'variants', 'media', 'firstMedia')
    ->withSum('variants', 'quantity')
    ->paginate(10);

    
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


        return view('dashboard.products.create', compact(
            'product',
            'tags',
            'categories',
            'subCategories',
            'sizes',
            'colors'
        ));
    }
    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
     
        // بدء المعاملة
        // DB::beginTransaction();
        
        try {
            // التحقق من صحة البيانات
            $request->validate(Category::rules($request->id ?? null));
    
            // إعداد البيانات
            $categoryName = Str::slug($request->name_en, '-');
            $data = $request->except(['name', 'tags', 'category_id', 'image', 'sizes', 'colors', 'quantities']);
            $data['slug'] = $categoryName;
            $data['category_id'] = $request->sub_category;
            $data['store_id'] = 1;
            $data['name']  = ['en' => $request->name_en,'ar' => $request->name_ar];
            $data['description']  = ['en' => $request->description_en,'ar' => $request->description_ar];
            

            // إنشاء المنتج
            $product = Product::create($data);
    
            // إضافة المتغيرات (الـ variants)
            foreach ($request->sizes as $index => $size) {
                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->size_id = $size;
                $variant->color_id = $request->colors[$index];
                $variant->quantity = $request->quantities[$index];
                $variant->sku = ProductVariant::generateSKU($product->name_en, $product->color, $product->size);

                $variant->save();
            }
    
            if ($request->images && count($request->images) > 0) {
                $i = 1;
                $manager = new ImageManager( New Driver); 
                
                foreach ($request->images as $image) {
                    $file_name = $product->slug . '_' . time() . '_' . $i . '.' . $image->getClientOriginalExtension();
                    $file_size = $image->getSize();
                    $file_type = $image->getMimeType();
                    $path = public_path('assets/products/' . $file_name);

                    $img = $manager->read($image->getRealPath());

                    $img->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
    
                    $img->save($path, 100);
    
                    $product->media()->create([
                        'file_name' => $file_name,
                        'file_size' => $file_size,
                        'file_type' => $file_type,
                        'file_status' => true,
                        'file_sort' => $i,
                    ]);
                    $i++;
                }
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
    
            // ربط المنتج بالعلامات
            $product->tags()->sync($tag_ids);
            Cache::forget('shop_tags_menu');
            // تحديث رمز المنتج
            $product->update(['product_code' => $product->id]);
    
            // تأكيد المعاملة
            DB::commit();
    
            return redirect()->route('dashboard.products.index')->with('success', 'تم إنشاء المنتج بنجاح!');
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
        
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $tags = implode(',', $product->tags()->pluck('name')->toArray());
        $categories = Category::whereNull('parent_id')->pluck('name', 'id');
        $category = $product->category;
        $subCategories = $category->parent_id ? Category::where('parent_id', $category->parent_id)->get() : collect();
        $parentCategory = $category->parent_id ? Category::find($category->parent_id) : null;
        return view('dashboard.products.show', compact(
            'product',
            'tags',
            'categories',
            'subCategories',
            'parentCategory'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $tags = implode(',', $product->tags()->pluck('name')->toArray());
        $categories = Category::whereNull('parent_id')->pluck('name', 'id');
        $category = $product->category;
        $subCategories = $category->parent_id ? Category::where('parent_id', $category->parent_id)->get() : collect();
        $parentCategory = $category->parent_id ? Category::find($category->parent_id) : null;

        return view('dashboard.products.edit', compact(
            'product',
            'tags',
            'categories',
            'subCategories',
            'parentCategory'
        ));
    }
    
    public function update(Request $request, Product $product)
    {
        $data = $request->except('name','tags', 'category_id', 'image');  // Exclude unnecessary fields
        $data['name'] = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $data['description'] = ['en' => $request->description_en, 'ar' => $request->description_ar];
   
        $product->update($data);
        if ($request->has('sub_category')) {
            $product->update(['category_id' => $request->sub_category]);
        }
        $tags = json_decode($request->post('tags'));
        $tag_ids = collect($tags)->map(function ($item) {
            $slug = Str::slug($item->value);
            return Tag::firstOrCreate(['slug' => $slug], ['name' => $item->value])->id;
         
        });
        $product->tags()->sync($tag_ids);
        Cache::forget('shop_tags_menu');
        if ($request->images && count($request->images) > 0) {
            $i = $product->media()->count() + 1;
            $manager = new ImageManager( New Driver); 
            foreach ($request->images as $image) {
                $file_name = $product->slug . '_' . time() . '_' . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/products/' . $file_name);
                $img = $manager->read($image->getRealPath());
                $img->resize(1000, 667, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($path, 90);
                $product->media()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => true,
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        if ($request->has('variant') && $request->has('quantities')) {
            $variants = $request->input('variant');
            $quantities = $request->input('quantities');

            foreach ($variants as $index => $variant_id) {
                ProductVariant::where('id', $variant_id)
                    ->update(['quantity' => $quantities[$index]]);
            }
        }
        return redirect()->route('dashboard.products.index', $product->id)
            ->with('success', __('messages.update'));
    }

    public function destroy(Product $product, Request $request)
    {
        if ($request->page_id == 2) {
            $delete_select_id = explode(",", $request->delete_select_id);

            Product::destroy($delete_select_id);

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

    public function remove_image(Request $request)
    {    
        $product = Product::findOrFail($request->product_id);
        $image = $product->media()->whereId($request->image_id)->first();
        if (File::exists('assets/products/'. $image->file_name)){
            unlink('assets/products/'. $image->file_name);
        }
        $image->delete();
        return true;
    }

}
