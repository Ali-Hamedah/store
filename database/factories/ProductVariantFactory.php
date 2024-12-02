<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;

class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id, // ربط المنتج
            'color_id' => Color::inRandomOrder()->first()->id, // اختيار لون عشوائي
            'size_id' => Size::inRandomOrder()->first()->id, // اختيار مقاس عشوائي
            'quantity' => $this->faker->numberBetween(1, 50), // الكمية المتاحة
            'sku' => $this->faker->unique()->uuid, // رمز SKU الفريد
        ];
    }
}
