<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;


class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:view category|create category|edit category|delete category'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create category'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:update category'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete category'], ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = Category::withCount('products')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

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

        
        if ($image = $request->file('image')) {
            $manager = new ImageManager(new Driver);
            $file_name = Str::slug($request->name) . "." . $image->getClientOriginalExtension();
            $path = public_path('/assets/categories/' . $file_name);
            $img = $manager->read($image->getRealPath());
            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $data['image'] = $file_name;
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

        if ($image = $request->file('image')) {
            $manager = new ImageManager(new Driver);
            if ($category->image != null && File::exists('assets/categories/' . $category->image)) {
                unlink('assets/categories/' . $category->image);
            }
            $file_name = Str::slug($request->name) . "." . $image->getClientOriginalExtension();
            $path = public_path('/assets/categories/' . $file_name);
            $img = $manager->read($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $data['image'] = $file_name;
        }
        $category->update($data);
        toastr()->success(__('messages.edit'));
        return redirect()->route('dashboard.categories.index');
    }


    public function destroy(Request $request, Category $category)
    {
        if ($request->page_id == 2) {
            $delete_select_id = explode(",", $request->delete_select_id);
            foreach ($delete_select_id as $id) {
                // جلب الكائن المرتبط بالمعرف
                $category = Category::find($id);

                // التحقق مما إذا كان الكائن موجودًا
                if ($category) {
                    // التحقق مما إذا كانت الصورة موجودة في المسار المحدد
                    if (File::exists('assets/categories/' . $category->image)) {
                        // حذف الصورة
                        unlink('assets/categories/' . $category->image);
                    }
                }
            }

            Category::destroy($delete_select_id);

            // $category->delete();
            return redirect()->route('dashboard.categories.index')->with('success', __('messages.delete'));
        } else {
            if (File::exists('assets/categories/' . $category->image)) {
                unlink('assets/categories/' . $category->image);
            }

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
