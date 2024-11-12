<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

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
}
