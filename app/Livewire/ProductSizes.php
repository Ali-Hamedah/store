<?php

namespace App\Livewire;



use App\Models\Product;
use Livewire\Component;
use App\Models\ProductVariant;

class ProductSizes extends Component
{
    public $productId;
    public $colorId;
    public $sizes = [];
    public $products;  // إضافة الخاصية
    public $colors;    // إضافة الخاصية

    // تحميل المنتجات والألوان عند تحميل المكون
    public function mount($products, $colors)
    {
        $this->products = $products;
        $this->colors = $colors;
    }

    // تحميل المقاسات عندما تتغير أي من المعاملات
    public function updated($propertyName)
    {
        if ($this->productId && $this->colorId) {
            $this->loadSizes();
        }
    }

    public function loadSizes()
    {
        // استرجاع المقاسات المرتبطة بالمنتج واللون
        $this->sizes = ProductVariant::where('product_id', $this->productId)
                    ->where('color_id', $this->colorId)
                    ->pluck('size', 'id');
    }

    public function render()
    {
        return view('livewire.product-sizes');
    }
}
