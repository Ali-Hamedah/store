<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 

        Route::middleware(['auth', 'verified'])->prefix('dashboard')->as('dashboard.')->group(function() {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
            Route::get('/categories/trash', [CategoryController::class, 'trash_Category'])->name('categories.trash');
        
            Route::post('/categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
        
            Route::post('/categories/restoreAll{id}', [CategoryController::class, 'restoreAll'])->name('categories.restoreAll');
        
            Route::delete('/categories/force-delete/{id}', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
                   
            Route::resource('categories', CategoryController::class);

            Route::resource('products', ProductController::class);
        });
        
    });
