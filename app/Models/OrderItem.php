<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'product_name',
        // أضف الحقول الأخرى هنا إذا لزم الأمر
    ];
    protected $table = 'order_items';

    public $incrementing = true;

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => $this->product_name
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
