<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        $faker = Factory::create();

        Product::all()->each(function ($product) use ($faker) {
            for ($i = 1; $i < rand(1, 3); $i++) {
                $product->reviews()->create([
                    'user_id' => 1,
                    'name' => $faker->userName,
                    'email' => $faker->safeEmail,
                    'title' => $faker->sentence,
                    'message' => $faker->paragraph,
                    'status' => rand(0,1),
                    'rating' => rand(1,5),
                ]);
            }
        });

        Schema::enableForeignKeyConstraints();
    }
}
