<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
  
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'product-list',
        'product-create',
        'product-edit',
        'product-delete'
    ];

    public function run(): void
    {
        // استدعاء Seeder الخاص بالمستخدمين
        // $this->call([
        //     UserSeeder::class,
        // ]);

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

        $this->call([
            ProductCouponSeeder::class,
        ]);
        $this->call([
            ProductReviewSeeder::class,
        ]);
        // $this->call([
        //     UserRolePermissionSeeder::class,
        // ]);


        // Create permissions.
        // foreach ($this->permissions as $permission) {
        //     Permission::create(['name' => $permission]);
        // }

        // // Create admin User and assign the role to him.
        // $user = User::create([
        //     'name' => 'Prevail Ejimadu',
        //     'email' => 'supervisor@admin.com',
        //     'password' => Hash::make('password'),
        //     'phone_number' => '068181863821',
        //     'country' => fake()->countryCode(),
        // ]);

        // $role = Role::create(['name' => 'Supervisor']);

        // $permissions = Permission::pluck('id', 'id')->all();

        // $role->syncPermissions($permissions);

        // $user->assignRole([$role->id]);
    }
}
