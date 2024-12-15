<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\Category;
use App\Services\CurrencyConverter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
        
        $this->app->singleton('currency', function () {
            return new \App\Helpers\Currency;
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        view()->composer('front.layouts.front', function ($view) {
            $categories = Category::whereNull('parent_id')->with('children')->get(); // جلب الأقسام من قاعدة البيانات
            $view->with('categories', $categories);
        });

        if (!request()->is('admin/*')) {
            view()->composer('*', function ($view) {
                if (!Cache::has('shop_categories_menu')) {
                    Cache::forever('shop_categories_menu', Category::tree());
                }
                $shop_categories_menu = Cache::get('shop_categories_menu');

                if (!Cache::has('shop_tags_menu')) {
                    Cache::forever('shop_tags_menu', Tag::whereHas('products', function ($query) {
                        $query->whereNotNull('products.id'); // تحديد الجدول صراحةً
                    })->get());
                    
                }
                $shop_tags_menu = Cache::get('shop_tags_menu');

                $view->with([
                    'shop_categories_menu' => $shop_categories_menu,
                    'shop_tags_menu' => $shop_tags_menu,
                ]);
            });
        }

        if (request()->is('admin/*')) {
            view()->composer('*', function ($view) {
                if (!Cache::has('admin_side_menu')) {
                    Cache::forever('admin_side_menu', Permission::tree());
                }
                $admin_side_menu = Cache::get('admin_side_menu');

                $view->with([
                    'admin_side_menu' => $admin_side_menu
                ]);
            });
        }
        
    }
}
