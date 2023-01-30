<?php

use App\Http\Controllers\ExchangeRatesController;
use Illuminate\Support\Facades\Route;

Route::get('/rates', [ExchangeRatesController::class, 'index']);
Route::post('/selection/save', [ExchangeRatesController::class, 'save']);
Route::get('/selection/{date}', [ExchangeRatesController::class, 'view']);
