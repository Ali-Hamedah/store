<?php

namespace Database\Factories;

use App\Models\Size;
use App\Models\Color;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word;
        $name_ar = $this->faker->unique()->word;
        return [
            'name' =>  ['en' => $name,'ar' => $name_ar],
            'slug' => Str::slug($name . '-' . $name_ar) . '-' . uniqid(),  
            'description' => $this->faker->sentence(15),
            'image' => $this->faker->imageUrl(600, 600),
            'price' => $this->faker->randomFloat(1, 1, 499),
            'compare_price' => $this->faker->randomFloat(1, 500, 999),
            'quantity' => 10,
            'category_id' => Category::inRandomOrder()->first()->id,
            'is_featured' => rand(0, 1),
            'store_id' => Store::inRandomOrder()->first()->id,
        ];
    }
}
