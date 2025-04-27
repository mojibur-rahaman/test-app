<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ProfileController; 

Route::controller(FrontEndController::class)->group(function(){
    Route::get('/','index')->name('home');
});
Route::get('/search',[SearchController::class,'searchProduct'])->name('user.search');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'edit')->name('profile.edit');
    Route::patch('/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
})->middleware('auth');

require __DIR__.'/auth.php';

// 404 Page Not Found Handle ----------------------------------------------->>
Route::fallback(function () {
    return Inertia::render('FrontEnd/UnhandlePage');
});
