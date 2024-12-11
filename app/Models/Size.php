<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['name'];
    public $translatable = ['name'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
