<?php

namespace App\Livewire\Front;

use App\Models\Tag;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class ShopProductsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 12;
    public $slug;
    public $categoryId;
    public $tagId;
    public $sortingBy = 'default';

    public function mount($slug = null)
    {
        $this->slug = $slug;
        // حاول الحصول على الفئة أو العلامة استنادًا إلى الـ slug
        $category = Category::where('slug', $slug)->first();
        $tag = Tag::where('slug', $slug)->first();

        // إذا تم العثور على الفئة، احفظ الـ categoryId، وإلا استخدم العلامة
        if ($category) {
            $this->categoryId = $category->id;
        } else {
            $this->categoryId = null;
        }

        // إذا تم العثور على العلامة، احفظ الـ tagId
        if ($tag) {
            $this->tagId = $tag->id;
        } else {
            $this->tagId = null;
        }
    }

    public function loadProducts()
{
    // استعلام لتحميل المنتجات بناءً على الفئة
    $query = Product::query();

    // تصفية المنتجات حسب الفئة
    if ($this->categoryId) {
        $subCategories = Category::where('parent_id', $this->categoryId)->pluck('id')->toArray();
        $subCategories[] = $this->categoryId; // إضافة الفئة الرئيسية
        $query->whereIn('category_id', $subCategories);
    }

    // تصفية المنتجات حسب العلامة إذا تم تحديدها
    if ($this->tagId) {
        $query->whereHas('tags', function($q) {
            $q->where('tags.id', $this->tagId);
        });
    }

    // تطبيق الفلاتر الخاصة بالترتيب
    if ($this->sortingBy === 'popularity') {
        $query->orderBy('rating', 'DESC');
    } elseif ($this->sortingBy === 'low-high') {
        $query->orderBy('price', 'asc');
    } elseif ($this->sortingBy === 'high-low') {
        $query->orderBy('price', 'desc');
    }

    return $query;
}

public function changeCategory($categoryId)
{
    $this->categoryId = $categoryId;
    // عند التبديل بين الفئات، قد ترغب في إعادة تعيين العلامة (tag) أو الاحتفاظ بها
    $this->tagId = null;  // يمكن إعادة تعيين العلامة أو تركها كما هي، حسب الحاجة
}

    public function changeTag($tagId)
    {
        $this->tagId = $tagId;
        $this->categoryId = null; 
    }

    public function render()
    {
        $tags = Tag::withCount('products')->get(); // تحميل جميع العلامات مع عدد المنتجات المرتبطة بها
        $products = $this->loadProducts()->paginate($this->paginationLimit);
        $categories = Category::where('parent_id', $this->categoryId)->get();
    
        return view('livewire.front.shop-products-component', compact('products', 'categories', 'tags'));
    }
    
}
