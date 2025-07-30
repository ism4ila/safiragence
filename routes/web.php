<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\GalleryImageController;
use App\Http\Controllers\EncadreurController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\GalleryImageController as AdminGalleryImageController;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\ContactMessageController;

Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::resource('services', ServiceController::class);
Route::resource('testimonials', TestimonialController::class);
Route::resource('gallery', GalleryImageController::class);
Route::resource('encadreurs', EncadreurController::class);
Route::resource('cities', CityController::class);
Route::resource('settings', SiteSettingController::class);

use App\Http\Controllers\Admin\EncadreurController as AdminEncadreurController;

use App\Http\Controllers\Admin\CityController as AdminCityController;

use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Route d'accès admin principal - redirige vers login si non connecté
Route::get('/safir', [AdminDashboardController::class, 'index'])->middleware('auth')->name('admin.dashboard');

Route::prefix('safir')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('services', AdminServiceController::class);
    Route::resource('testimonials', AdminTestimonialController::class);
    Route::resource('gallery', AdminGalleryImageController::class);
    Route::resource('encadreurs', AdminEncadreurController::class);
    Route::resource('cities', AdminCityController::class);
    Route::resource('settings', AdminSiteSettingController::class);
});