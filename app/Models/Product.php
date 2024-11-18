<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'slug', 'description', 'image', 'category_id', 'store_id',
        'price', 'compare_price', 'status',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();

    }

    public function store()
    {
        return $this->belongsTo(Store::class)->withDefault();

    }
}
