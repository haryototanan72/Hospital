<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Order;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\OrderController;


Route::get('/', function () {
    return redirect('/patients-view');
});

Route::get('/patients-view', function () {
    $patients = Patient::all();
    return view('patients', compact('patients'));
});

Route::post('/patients-store', function (Request $request) {
    $request->validate([
        'name' => 'required|string',
        'address' => 'nullable|string',
        'phone' => 'nullable|string',
        'complaint' => 'nullable|string',
    ]);

    Patient::create($request->all());
    return redirect('/patients-view#data')->with('success', 'Pasien berhasil ditambahkan!');
});

Route::get('/orders-view', function () {
    $orders = Order::with('patient')->get();
    $patients = Patient::all(); 
    return view('orders', compact('orders', 'patients'));
});

Route::post('/orders-store', function (Request $request) {
    $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'product_name' => 'required|string',
        'quantity' => 'required|integer',
        'note' => 'nullable|string',
    ]);

    Order::create($request->all());
    return redirect('/orders-view#data')->with('success', 'Order berhasil ditambahkan!');
});


Route::get('/patients', [PatientController::class, 'index']);
Route::post('/patients-store', [PatientController::class, 'store']);
Route::get('/patients/{id}/edit', [PatientController::class, 'edit']);
Route::put('/patients/{id}', [PatientController::class, 'update']);
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders-store', [OrderController::class, 'store']);
Route::get('/orders/{id}/edit', [OrderController::class, 'edit']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);