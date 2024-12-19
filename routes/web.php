<?php

use Livewire\Livewire;
use App\Livewire\Counter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\front\CustomerController;

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

 Route::middleware(['auth', 'verified'])->group(function() {

    Route::get('/profie/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::patch('/profile', [CustomerController::class, 'update_profile'])->name('customer.update_profile');
    Route::get('/profile/remove-image', [CustomerController::class, 'remove_profile_image'])->name('customer.remove_profile_image');
   
    Route::get('/addresses', [CustomerController::class, 'addresses'])->name('customer.addresses');
    Route::post('/customer/address', [CustomerController::class, 'store'])->name('customer.address.store');
    Route::post('addresses/{address}/set-default', [CustomerController::class, 'setDefaultAddress'])->name('customer.address.setDefault');
    Route::get('/customer/addresses/{address}/edit', [CustomerController::class, 'addressEdit'])->name('customer.address.edit');
    Route::put('/customer/addresses/{address}', [CustomerController::class, 'addressUpdate'])->name('customer.address.update');
    Route::delete('/customer/addresses/{address}', [CustomerController::class, 'addressDelete'])->name('customer.address.delete');


   
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');




    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);
 });

        Route::get('/', [HomeController::class, 'index'])->name('home');;

        Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

        Route::resource('cart', CartController::class);
       
        Route::get('choose-login', [GoogleController::class, 'chooseLoginMethod'])->name('choose.login');
        Route::get('choose-registration', [GoogleController::class, 'chooseRegistrationMethod'])->name('choose.registration');
    
      // routes/web.php أو routes/api.php
        Route::get('/get-sizes/{colorId}', [ProductController::class, 'getSizes']);

        Route::get('/shop/{slug?}', [ProductController::class, 'shop'])->name('frontend.shop');
        // Route::get('/shop/tags/{slug}', [ProductController::class, 'shop_tag'])->name('frontend.shop_tag');
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post(LaravelLocalization::setLocale() . '/livewire/update', $handle)
                ->middleware(['guest']);
        });
    });
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
   
   
  
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon']);

    require __DIR__.'/dashboard.php';
    require __DIR__.'/auth.php';
 
