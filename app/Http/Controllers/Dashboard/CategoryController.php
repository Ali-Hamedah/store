<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::with('products')->paginate(10);
       
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
        return redirect()->route('dashboard.categories.index')->with('success', __('messages.add'));
    }


    public function show(Category $category)
    {
        
        return view('dashboard.categories.show', compact('category'));
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
        toastr()->success(__('messages.edit'));
        return redirect()->route('dashboard.categories.index');
    }


    public function destroy(Request $request, Category $category)
    {
        if ($request->page_id == 2) {
            $delete_select_id = explode(",", $request->delete_select_id);
        
            Category::destroy($delete_select_id);

        // $category->delete();
         return redirect()->route('dashboard.categories.index')->with('success', __('messages.delete'));
    }
    else {
            // if (!empty($category->image) && Storage::disk('images')->exists($category->image)) {
            //     // حذف الصورة إذا كانت موجودة
            //     Storage::disk('images')->delete($category->image);
            // }
            $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully');

    }
}
    

    public function trash_Category()
    {
        $categories = Category::onlyTrashed()->paginate(10);
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        
        $selectedItems = $request->selected_items;

        if ($selectedItems && is_array($selectedItems)) {
            // استعادة جميع الفئات المحددة
            Category::withTrashed()
                ->whereIn('id', $selectedItems)
                ->restore();
    
            return redirect()->route('dashboard.categories.trash')->with('success', 'Categories restored successfully.');
        }
        return redirect()->route('dashboard.categories.trash')->with('error', 'Category not found.');
    }


    public function restoreAll($id)
    {
        

        $category = Category::withTrashed()->find($id);
        if ($category) {
            $category->restore();
            return redirect()->route('dashboard.categories.trash')->with('success', 'Category restored successfully.');
        }
        return redirect()->route('dashboard.categories.trash')->with('error', 'Category not found.');
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

        if ($request->has('selected_items')) {
            Category::whereIn('id', $request->input('selected_items'))->delete();
            return redirect()->route('dashboard.categories.index')->with('success', 'تم حذف العناصر المحددة بنجاح.');
        }
        return redirect()->route('dashboard.categories.index')->with('error', 'لم يتم تحديد أي عنصر.');
    }
}
