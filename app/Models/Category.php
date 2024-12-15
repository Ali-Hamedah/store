<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes, SearchableTrait, HasTranslations;

    protected $fillable = ['name', 'parent_id', 'slug', 'description', 'image', 'status'];
    public $translatable = ['name', 'description'];

    public static function rules($id)
    {
        return [
            'name_en' => [ "required", "string", "max:255", "unique:categories,name,$id",
                function ($attribute, $value, $fail) {
                    $forbiddenNames = ['admin', 'superadmin'];
                    if (in_array(strtolower($value), $forbiddenNames)) {
                        $fail("The {$attribute} cannot be one of the reserved names.");
                    }
                },
            ],
            'name_ar' => ["required","string","max:255","unique:categories,name,$id",
                function ($attribute, $value, $fail) {
                    $forbiddenNames = ['admin', 'superadmin'];
                    if (in_array(strtolower($value), $forbiddenNames)) {
                        $fail("The {$attribute} cannot be one of the reserved names.");
                    }
                },
            ],
            'parent_id' => 'nullable|integer|exists:categories,id',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description_en' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];
    }

    protected $searchable = [
        'columns' => [
            'categories.name' => 10,
        ],
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public static function tree( $level = 1 )
    {
        return static::withCount('products')->with(implode('.', array_fill(0, $level, 'children')))
            ->whereNull('parent_id')
            ->whereStatus(true)
            ->orderBy('id', 'asc')
            ->get();
    }


    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
