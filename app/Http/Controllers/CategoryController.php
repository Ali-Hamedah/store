<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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

        $data['slug'] = $request->slug ?: Str::slug($request->name, '-');
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



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!empty($category->image) && Storage::disk('images')->exists($category->image)) {
            Storage::disk('images')->delete($category->image);
        }
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully');
    }
}
