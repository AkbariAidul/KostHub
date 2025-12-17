<?php

use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\Api\PromoCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans-callback', [MidtransController::class, 'callback']);

Route::post('/promo-check', [PromoCodeController::class, 'check']);