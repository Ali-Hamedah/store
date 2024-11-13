<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::paginate(10);
        return view('dashboard.categories.index', compact('categories'));
    }


    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    public function store(Request $request)
    {

        $request->validate(Category::rules($request->id ?? null));

        $categoryName = Str::slug($request->name, '-');
        $data = $request->only(['name', 'parent_id', 'description', 'status']);
        $data['slug'] = $categoryName;

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $categoryName . '-' . time() . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('categories', $fileName, 'images');
            $data['image'] = $imagePath;
        }
        Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully');
    }


    public function show(Category $category)
    {
        //
    }


    public function edit(Category $category)
    {

        $category = Category::findOrFail($category->id);
        $parents = Category::all();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }


    public function update(Request $request, Category $category)
    {

        $request->validate(Category::rules($category->id));

        $data['slug'] = $request->slug ?: Str::slug($request->name, '-');
        $data = $request->only(['name', 'parent_id', 'description', 'status']);
        if ($request->hasFile('image')) {
            if (!empty($category->image) && Storage::disk('images')->exists($category->image)) {
                Storage::disk('images')->delete($category->image);
            }
            $fileName = Str::slug($request->name, '-') . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $data['image'] = $request->file('image')->storeAs('categories', $fileName, 'images');
        }

        $category->update($data);
        toastr()->success('Category updated successfully');
        return redirect()->route('dashboard.categories.index');
    }


    public function destroy(Category $category)
    {

        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully');
    }

    public function trash_Category()
    {
        $categories = Category::onlyTrashed()->paginate(10);
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id);
        if ($category) {
            $category->restore();
            return redirect()->route('dashboard.categories.index')->with('success', 'Category restored successfully.');
        }
        return redirect()->route('dashboard.categories.index')->with('error', 'Category not found.');
    }


    public function forceDelete($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category) {
            if (!empty($category->image) && Storage::disk('images')->exists($category->image)) {
                Storage::disk('images')->delete($category->image);
            }
            $category->forceDelete();
            return redirect()->route('dashboard.categories.trash')->with('success', 'Category permanently deleted successfully.');
        }
        return redirect()->route('dashboard.categories.trash')->with('error', 'Category not found.');
    }

    public function deleteSelected(Request $request)
{
    // تحقق من أن هناك عناصر محددة
    if ($request->has('selected_items')) {
        // حذف العناصر المحددة
        Category::whereIn('id', $request->input('selected_items'))->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'تم حذف العناصر المحددة بنجاح.');
    }

    return redirect()->route('items.index')->with('error', 'لم يتم تحديد أي عنصر.');
}


}
