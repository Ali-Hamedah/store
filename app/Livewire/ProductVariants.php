<?php

namespace App\Livewire;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\ProductVariant;

class ProductVariants extends Component
{
    public $variants = []; // لتخزين البيانات الخاصة بكل متغير (اللون، المقاس، الكمية)
    public $products = []; // لتخزين المنتجات
    public $sizes = [];    // لتخزين المقاسات
    public $colors = [];   // لتخزين الألوان

    public function mount()
    {
        // تحميل البيانات عند تحميل المكون
        $this->products = Product::all();
        $this->sizes = Size::all();
        $this->colors = Color::all();
    }

    public function addVariant()
    {
        // إضافة متغير جديد (اللون، المقاس، الكمية)
        $this->variants[] = ['product_id' => null, 'size' => null, 'color' => null, 'quantity' => 1];
    }

    public function removeVariant($index)
    {
        // حذف متغير بناءً على الفهرس
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants); // لإعادة ترتيب الفهرس
    }

    public function save()
    { 
        // حفظ البيانات في قاعدة البيانات
        foreach ($this->variants as $variant) {
            // تخزين العلاقات بين المنتج والمقاس واللون
            ProductVariant::create([
                'product_id' => $variant['product_id'],
                'size_id' => $variant['size'],
                'color_id' => $variant['color'],
                'quantity' => $variant['quantity'],
                'sku' => Str::uuid()->toString(),
            ]);
        }

        

        session()->flash('message', 'تم حفظ البيانات بنجاح!');
    }

    public function sendData()
    {
        // إرسال البيانات عبر AJAX إلى الـ Controller
        $this->emit('sendDataToController', [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'status' => $this->status,
            'category_id' => $this->category_id,
            'variants' => $this->variants,
        ]);
    }
    public function render()
    {
        return view('livewire.product-variants');
    }
}
