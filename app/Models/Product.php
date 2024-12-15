<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'category_id',
        'store_id',
        'price',
        'compare_price',
        'status',
        'is_featured',
         'is_new', 
        'is_offer'
    ];
    public $translatable = ['name', 'description'];

    public static function rules($id)
    {
        return [
            'name_en' => 'required|string|max:255',
    'name_ar' => 'required|string|max:255',
    'description_en' => 'required|string',
    'description_ar' => 'required|string',
    'price' => 'required|numeric|min:0',
    'compare_price' => 'nullable|numeric|min:0',
    'sub_category' => 'required|exists:categories,id',
    'sizes' => 'required|array|min:1',
    'colors' => 'required|array|min:1',
    'quantities' => 'required|array|min:1',
    'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
           

        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function subCategory() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class)->withDefault();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'product_id', 'id');
}

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function colors()
{
    return $this->hasManyThrough(Color::class, ProductVariant::class, 'product_id', 'id', 'id', 'color_id')->distinct();
}

public function firstMedia(): MorphOne
{
    return $this->morphOne(Media::class, 'mediable')->orderBy('file_sort', 'asc');
}

public function media(): MorphMany
{
    return $this->MorphMany(Media::class, 'mediable');

}

public function reviews()
{
    return $this->hasMany(ProductReview::class);
}

public function getAverageRatingAttribute()
{
    // إذا كنت تريد حساب متوسط التقييمات من علاقة ratings
    return $this->reviews()->avg('rating') ?? 0; // احصل على المتوسط أو 0
}

public function getImageUrl($default = 'no_image.jpg')
{
    
    $imagePath = $this->media;

    $imageFullPath = public_path('assets/products/' . $imagePath);

    if ($imagePath && file_exists($imageFullPath)) {
        return asset('assets/products/' . $imagePath);
    }

    return asset('assets/products/' . $default);
}

public function getDiscountPercentageAttribute()
{
    if (!$this->compare_price) {
        return 0;
    }

    $discountPercentage = (($this->compare_price - $this->price) / $this->compare_price) * 100;
    return round($discountPercentage, 1);
}

// المنتجات المفضلة
public function scopeFavorite($query)
{
    return $query->where('is_featured', 1);
}

// المنتجات الجديدة
public function scopeNew($query)
{
    return $query->where('created_at', '>=', now()->subDays(30)); // أُضيفت خلال آخر 30 يومًا
}

// المنتجات التي عليها تخفيض
public function scopeDiscounted($query)
{
    return $query->where('compare_price', '>', 'price'); // الحقول المخفضة
}



}


