<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'color_id', 'size_id', 'quantity', 'sku'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public static function generateSKU($productName, $colorName, $sizeName)
    {
        return strtoupper(substr($productName, 0, 3)) . '-' . strtoupper(substr($colorName, 0, 3)) . '-' . strtoupper($sizeName);
    }
}
