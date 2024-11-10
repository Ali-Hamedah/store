<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        return view('dashboard.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // الحصول على اسم القسم واستخدامه كاسم للملف
        $categoryName = Str::slug($request->name, '-'); // تحويل الاسم إلى صيغة صالحة للملفات
        $extension = $request->file('image')->getClientOriginalExtension(); // استخراج الامتداد الأصلي للصورة
        $fileName = $request->name . '.' . $extension; // تكوين اسم الملف باستخدام اسم القسم

        // تخزين الملف في مجلد "images" مع الاسم المخصص
        $imagePath = $request->file('image')->storeAs('images', $fileName, 'public');
        $data = $request->all();
        $data['image_path'] = $imagePath;
        $data['slug'] = $categoryName;
        Category::create($data);

        // toastr()->success('Data has been saved successfully!');
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        
        $category = Category::findOrFail($category->id);
        $parents = Category::all();
      return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, Category $category)
     {

         $request->validate([
             'name' => 'required|string|max:255',
             'parent_id' => 'nullable|integer|exists:categories,id',
             'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
             'description' => 'nullable|string|max:1000',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);
     
         // تجميع البيانات المحدثة
         $data = $request->only(['name', 'parent_id', 'description', 'status']);
         // إنشاء slug إذا لم يُقدم في الطلب
         $data['slug'] = $request->slug ?: Str::slug($request->name, '-');
     
         // معالجة رفع الصورة إذا كانت موجودة
         if ($request->hasFile('image')) {
             $categoryName = Str::slug($request->name, '-'); // إنشاء اسم فريد للصورة بناءً على الاسم
             $extension = $request->file('image')->getClientOriginalExtension();
             $fileName = $categoryName . '.' . $extension;
     
             // تخزين الصورة في مجلد "images" في التخزين العام
             $imagePath = $request->file('image')->storeAs('images', $fileName, 'public');
             $data['image_path'] = $imagePath;
         }
         $category->update($data);
         toastr()->success('Category updated successfully');
         return redirect()->route('dashboard.categories.index');
     }
     
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
