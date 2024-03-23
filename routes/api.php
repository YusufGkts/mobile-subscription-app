<?php

use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/check-subscription', [SubscriptionController::class, 'checkSubscription']);
Route::post('/purchase', [PurchaseController::class, 'store']);
