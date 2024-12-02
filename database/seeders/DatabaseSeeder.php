<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // استدعاء Seeder الخاص بالمستخدمين
        $this->call([
            UserSeeder::class,
        ]);

        // إنشاء التصنيفات
        Category::factory(10)->create();

        // إنشاء المتاجر
        Store::factory(5)->create();

        // استدعاء Seeders للألوان والمقاسات
        $this->call([
            ColorSeeder::class,
            SizeSeeder::class,
        ]);

        // إنشاء المنتجات
        $products = Product::factory(11)->create();

        // إنشاء متغيرات المنتجات لكل منتج
        $products->each(function ($product) {
            ProductVariant::factory(rand(1, 5))->create([
                'product_id' => $product->id, // ربط المتغير بالمنتج
            ]);
        });
    }
}
