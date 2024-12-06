<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

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

    public static function rules($id)
    {
        return [
            'name' => [
                "required",
                "string",
                "max:255",
                "unique:categories,name,$id",
                function ($attribute, $value, $fail) {
                    $forbiddenNames = ['admin', 'superadmin'];
                    if (in_array(strtolower($value), $forbiddenNames)) {
                        $fail("The {$attribute} cannot be one of the reserved names.");
                    }
                },
            ],
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Price' => 'nullable|numeric|max:10000',
            'compare_price' => 'nullable|numeric|max:10000',
            'tags' => 'required|',
            'is_featured' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_offer' => 'nullable|boolean',
           

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

public function averageRating()
{
    return $this->reviews()->avg('rating');
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


}


