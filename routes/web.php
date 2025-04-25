<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\OrderController;

// Redirect ke halaman utama
Route::get('/', function () {
    return redirect('/patients');
});

// =========================
// ROUTE PASIEN (Controller)
// =========================
Route::get('/patients', [PatientController::class, 'index']);
Route::post('/patients-store', [PatientController::class, 'store']);
Route::get('/patients/{id}/edit', [PatientController::class, 'edit']);
Route::put('/patients/{id}', [PatientController::class, 'update']);
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

// =========================
// ROUTE ORDER (Controller)
// =========================
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders-store', [OrderController::class, 'store']);
Route::get('/orders/{id}/edit', [OrderController::class, 'edit']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

// Rekomendasi real-time (dipanggil via JS)
Route::get('/orders/recommendation/{patientId}', [OrderController::class, 'getRecommendation']);
