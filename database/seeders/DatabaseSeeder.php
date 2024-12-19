<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        
        Category::factory(10)->create();

        Store::factory(5)->create();
     
        $this->call([
            ColorSeeder::class,
            SizeSeeder::class,
        ]);

        $products = Product::factory(80)->create();

        $products->each(function ($product) {
            ProductVariant::factory(rand(1, 5))->create([
                'product_id' => $product->id, 
            ]);
        });

        $this->call([
            ProductCouponSeeder::class,
        ]);
        $this->call([
            ProductReviewSeeder::class,
        ]);
        $this->call([
            UserRolePermissionSeeder::class,
        ]);
    }
}
