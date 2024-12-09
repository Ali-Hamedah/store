<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes, SearchableTrait;

    protected $fillable = ['name', 'parent_id', 'slug', 'description', 'image', 'status'];

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
            'parent_id' => 'nullable|integer|exists:categories,id',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:1000',
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


    public function subCategories() {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
