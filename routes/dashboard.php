<?php


use Livewire\Livewire;
use App\Livewire\Counter;
use App\Models\ProductCoupon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;

use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\ProductCouponController;
use App\Http\Controllers\Dashboard\ProductReviewController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/counter', Counter::class); // مسار Livewire لعداد
// Route::middleware('guest')->group(function () {
//     Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
//     Route::post('register', [RegisteredUserController::class, 'store']);
//     Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
//     Route::post('login', [AuthenticatedSessionController::class, 'store']);
// });

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(), // إضافة التوطين في المسار
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    
    ], function() { 

        Route::middleware(['auth', 'verified', 'role:super-admin|admin'])->prefix('dashboard')->as('dashboard.')->group(function() {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
            Route::get('/categories/trash', [CategoryController::class, 'trash_Category'])->name('categories.trash');
        
            Route::post('/categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
        
            Route::post('/categories/restoreAll{id}', [CategoryController::class, 'restoreAll'])->name('categories.restoreAll');
        
            Route::delete('/categories/force-delete/{id}', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
                   
            Route::get('/section/{id}', [ProductController::class, 'getSubcategories'])->name('section.get');

            Route::resource('categories', CategoryController::class);
            Route::resource('products', ProductController::class);
            Route::resource('orders', OrderController::class);

            Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
            Route::get('/notifications_ReadAll', [NotificationController::class, 'ReadAll'])->name('ReadAll');
            Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
            Route::post('/products/remove-image', [ProductController::class, 'remove_image'])->name('products.remove_image');
        
            Route::resource('product_coupons', ProductCouponController::class);

            Route::resource('product_reviews', ProductReviewController::class);

            Route::resource('customer', CustomerController::class);

            Route::resource('permissions', PermissionController::class);
            Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy'])->name('delete.permissions');
        
            Route::resource('roles', RoleController::class);
            Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
            Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('give-permissions');
            Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole'])->name('give-permissions');
        
            Route::resource('users', UserController::class);
            Route::get('users/{userId}/delete', [UserController::class, 'destroy']);

            Livewire::setUpdateRoute(function ($handle) {
                return Route::post(LaravelLocalization::setLocale() . '/livewire/update', $handle)
                    ->middleware(['auth']);
            });
          
        });
        
    });
require __DIR__.'/auth.php';
