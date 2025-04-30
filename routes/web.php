<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\ThankYouController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Owner\ManageAssetController;
use App\Http\Controllers\Owner\ManageUserRoleController;
use App\Http\Controllers\Owner\OwnerDashboardController;
//Guest Routes ------------------------------------------------------------>>
Route::controller(FrontEndController::class)->group(function(){
    Route::get('/','index')->name('home');
    Route::get('/product/{product_id}','prodcutView')->name('product.view');
});
Route::get('/search',[SearchController::class,'searchProduct'])->name('user.search');
// Check Out Manage -------------------------------------------------------->>
Route::controller(CheckOutController::class)->group(function () {
    Route::get('/checkout','index')->name('user.checkout');
    Route::post('/checkout','store')->name('user.checkout'); 
 });
 // Login User Access ------------------------------------------------------->>
Route::get('/thankyou',[ThankYouController::class,'thanks'])->middleware(['auth'])->name('user.thankyou'); 
// Authentication ----------------------------------------------------------->>
Route::controller(AuthController::class)->group(function(){
   Route::get('/login','index')->name('login'); 
   Route::post('/login','registerOrLogin')->name('login');  
});   
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'edit')->name('profile.edit');
    Route::patch('/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
})->middleware('auth');

require __DIR__.'/auth.php';

// Admin Access Pages -------------------------------------------------------->>
Route::prefix('/admin')->middleware(['admin','verified'])->group(function () {
    // admin dashboard 
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    // Searching 
    Route::get('/search',[SearchController::class,'adminSearch'])->name('admin.search');
    // Manage Product
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('admin.products.index');
        Route::get('/addproduct', 'create')->name('admin.products.create');
        Route::post('/addproduct', 'store')->name('admin.products.store');
        Route::get('/product/{product_id}/edit', 'edit')->name('admin.products.edit');
        Route::post('/product/{product_id}/edit', 'update')->name('admin.products.update');
    });
    // Manage Users
    Route::controller(AuthController::class)->group(function () {
       Route::get('/customers','adminIndex')->name('admin.customer.index'); 
    }); 
 
    // Manage Orders
    Route::controller(OrderController::class)->group(function () {
       Route::get('/orders','index')->name('admin.order.index'); 
       Route::get('/order/{order_id}/edit','edit')->name('admin.order.edit');
       Route::put('/order/{order_id}/update','update')->name('admin.order.update');
    }); 
 
 }); 




// Owner Access Pages -------------------------------------------------------->>
Route::prefix('/owner')->middleware(['owner','verified'])->group(function () {
    // Owner Dashboard
    Route::get('/dashboard',[OwnerDashboardController::class,'index'])->name('owner.dashboard');
    // Owner Access
    Route::controller(ManageUserRoleController::class)->group(function () {
       Route::get('/user','index')->name('owner.user.index');
       Route::get('/adduser', 'create')->name('owner.user.create');
       Route::post('/adduser', 'store')->name('owner.user.create');
       Route::get('/user/{user_id}/edit', 'edit')->name('owner.user.edit');
       Route::post('/user/{user_id}/edit', 'update')->name('owner.user.edit'); 
    });
    // Asset Managment
    Route::controller(ManageAssetController::class)->group(function(){
       Route::get('/asset','index')->name('owner.asset.index');
       Route::post('/asset','store')->name('owner.asset.index');
       Route::delete('/asset','removeBanner')->name('owner.asset.remove');
    });
 });


 
// 404 Page Not Found Handle ----------------------------------------------->>
Route::fallback(function () {
    return Inertia::render('FrontEnd/UnhandlePage');
});
