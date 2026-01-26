<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaFileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteAssetController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\HomeSettingsController;
use App\Http\Controllers\Admin\HomeServiceController;
use App\Http\Controllers\Admin\HomeProductController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\SocialLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::get('/site-logo', [SiteAssetController::class, 'logo'])->name('site.logo');
Route::get('/favicon.ico', [SiteAssetController::class, 'favicon'])->name('site.favicon');
Route::get('/apple-touch-icon.png', [SiteAssetController::class, 'appleTouchIcon'])->name('site.apple-touch-icon');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/media/{mediaFile}', [MediaFileController::class, 'show'])->name('media.show');

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
    Route::resource('companies', CompanyController::class)->except(['show']);
    Route::resource('promotions', PromotionController::class)->except(['show']);
    Route::resource('social-links', SocialLinkController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
