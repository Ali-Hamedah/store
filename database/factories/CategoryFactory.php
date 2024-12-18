<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'name' => $name, 
            'parent_id' => null, 
            'slug' => Str::slug($name), 
            'description' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(100, 100, 'categories', true), // رابط صورة وهمي
       
        ];
    }
}
