<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CheckoutController;
use App\Livewire\Counter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/






Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 

        // Route::get('/', function () {
            
        // });
     
        Route::get('/', [HomeController::class, 'index'])->name('home');;

        Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

        Route::resource('cart', CartController::class);

        Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
        Route::post('checkout', [CheckoutController::class, 'store']);
    
      // routes/web.php أو routes/api.php
        Route::get('/get-sizes/{colorId}', [ProductController::class, 'getSizes']);

    });
 

    require __DIR__.'/dashboard.php';