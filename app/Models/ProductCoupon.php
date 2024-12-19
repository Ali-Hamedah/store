<?php


namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCoupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'expire_date' => 'datetime',
    ];

    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function discount($total)
    {
        if (!$this->canBeUsed()) {
            return 0;
        }

        return $this->checkGreaterThan($total) ? $this->calculateDiscount($total) : 0;
    }

    public function canBeUsed()
    {
        return $this->checkDate() && $this->checkUsedTimes();
    }

    protected function checkDate()
    {
        return $this->expire_date ? Carbon::now()->between($this->start_date, $this->expire_date, true) : true;
    }

    protected function checkUsedTimes()
    {
        return $this->use_times ? $this->use_times > $this->used_times : true;
    }

    protected function checkGreaterThan($total)
    {
        return $this->greater_than ? $total >= $this->greater_than : true;
    }

    public function calculateDiscount($total)
    {
        switch ($this->type) {
            case 'fixed':
                return $this->value;
            case 'percentage':
                return ($this->value / 100) * $total;
            default:
                return 0;
        }
    }

    public function calculateProductDiscount(Product $product)
{
    // مثال: خصم بنسبة مئوية أو مبلغ ثابت
    if ($this->type == 'percentage') {
        return $product->price * ($this->value / 100);
    } elseif ($this->type == 'fixed') {
        return min($this->value, $product->price);
    }
    return 0;
}

}
