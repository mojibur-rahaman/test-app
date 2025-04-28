<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;

Route::controller(FrontEndController::class)->group(function(){
    Route::get('/','index')->name('home');
    Route::get('/product/{product_id}','prodcutView')->name('product.view');
});
Route::get('/search',[SearchController::class,'searchProduct'])->name('user.search');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'edit')->name('profile.edit');
    Route::patch('/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
})->middleware('auth');

require __DIR__.'/auth.php';

// Admin Access Pages -------------------------------------------------------->>
Route::prefix('/admin')->middleware(['auth'])->group(function () {
    // admin dashboard 
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    // Searching 
    // Route::get('/search',[searchController::class,'adminSearch'])->name('admin.search');
    // Manage Product
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('admin.products.index');
        Route::get('/addproduct', 'create')->name('admin.products.create');
        Route::post('/addproduct', 'store')->name('admin.products.store');
        Route::get('/product/{product_id}/edit', 'edit')->name('admin.products.edit');
        Route::post('/product/{product_id}/edit', 'update')->name('admin.products.update');
    });
    // Manage Users
    // Route::controller(authController::class)->group(function () {
    //    Route::get('/customers','adminIndex')->name('admin.customer.adminIndex'); 
    // }); 
 
    // Manage Orders
    // Route::controller(orderController::class)->group(function () {
    //    Route::get('/orders','index')->name('admin.order.index'); 
    //    Route::get('/order/{order_id}/edit','edit')->name('admin.order.edit');
    //    Route::put('/order/{order_id}/update','update')->name('admin.order.update');
    // }); 
 
 }); 

// 404 Page Not Found Handle ----------------------------------------------->>
Route::fallback(function () {
    return Inertia::render('FrontEnd/UnhandlePage');
});
