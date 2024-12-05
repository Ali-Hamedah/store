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

    public static function generateSKU($productName, $color, $size)
    {
        $convertToEnglish = function ($text) {
            if (!preg_match('/^[A-Za-z0-9]+$/', $text)) {
                return 'AT';
            }
            return strtoupper(preg_replace('/[^A-Z0-9]/', '', $text ?? 'UNK'));
        };
    
        $productPart = strtoupper(substr($convertToEnglish($productName), 0, 2));
        $colorPart = strtoupper(substr($convertToEnglish($color), 0, 2));
        $sizePart = strtoupper(substr($convertToEnglish($size), 0, 1));
        $datePart = date('ymd');
    
        // الرقم التسلسلي يبدأ بـ 01
        $newSerial = 1;
    
        do {
            $sku = "{$productPart}{$colorPart}{$sizePart}{$datePart}" . str_pad($newSerial, 2, '0', STR_PAD_LEFT);
            $newSerial++;
        } while (ProductVariant::where('sku', $sku)->exists());
    
        return $sku;
    }
    
    
    
}
