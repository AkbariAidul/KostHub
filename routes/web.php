<?php

use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/city/{slug}', [CityController::class, 'show'])->name('city.show');

Route::get('/kos/{slug}', [BoardingHouseController::class, 'show'])->name('kos.show');
Route::get('/kos/{slug}/rooms', [BoardingHouseController::class, 'rooms'])->name('kos.rooms');

Route::get('/kos/booking/{slug}', [BookingController::class, 'booking'])->name('booking');

Route::get('/kos/booking/{slug}/information', [BookingController::class, 'information'])->name('booking.information');
Route::post('/kos/booking/{slug}/information/save', [BookingController::class, 'saveinformation'])->name('booking.information.save');

Route::get('/kos/booking/{slug}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
Route::post('/kos/booking/{slug}/payment', [BookingController::class, 'payment'])->name('booking.payment');

Route::get('/booking-succes', [BookingController::class, 'succes'])->name('booking.succes');

Route::get('/find-kos', [BoardingHouseController::class, 'find'])->name('find-kos');
Route::get('/find-results', [BoardingHouseController::class, 'findResults'])->name('find-kos.results');

Route::get('/search-kos', [HomeController::class, 'search'])->name('kos.search');

Route::get('/check-booking', [BookingController::class, 'check'])->name('check-booking');
Route::post('/check-booking', [BookingController::class, 'show'])->name('check-booking.show');


Route::get('/saved', [App\Http\Controllers\BoardingHouseController::class, 'saved'])->name('saved-kos');
Route::get('/help', [App\Http\Controllers\HomeController::class, 'help'])->name('help');

// API untuk mengambil data kos berdasarkan list slug yang disimpan di browser
Route::get('/api/kos/saved-details', [App\Http\Controllers\BoardingHouseController::class, 'getSavedKos'])->name('api.kos.saved');

Route::get('/send-wa', [\App\Http\Controllers\TwilioController::class, 'send']);

Route::get('/test-wa', [WhatsAppController::class, 'test']);