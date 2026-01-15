<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeSettingsController;
use App\Http\Controllers\Admin\HomeServiceController;
use App\Http\Controllers\Admin\HomeProductController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\SocialLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/home', [HomeSettingsController::class, 'edit'])->name('home.edit');
    Route::put('/home', [HomeSettingsController::class, 'update'])->name('home.update');

    Route::resource('services', HomeServiceController::class)->except(['show']);
    Route::resource('products', HomeProductController::class)->except(['show']);
    Route::resource('promotions', PromotionController::class)->except(['show']);
    Route::resource('social-links', SocialLinkController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
