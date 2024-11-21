<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            'Price' => 'nullable|numeric|max:255',
            'compare_price' => 'nullable|numeric|max:1000',

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
}
