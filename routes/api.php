<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\OrderController;

Route::apiResource('patients', PatientController::class);
Route::apiResource('orders', OrderController::class);
Route::get('orders/recommendation/{patientId}', [OrderController::class, 'getRecommendationAndWarning']);

