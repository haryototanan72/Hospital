<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Order;

// Halaman view pasien + tabel
Route::get('/patients-view', function () {
    $patients = Patient::all();
    return view('patients', compact('patients'));
});

// Simpan data pasien dari form
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

// Halaman view order + tabel
Route::get('/orders-view', function () {
    $orders = Order::with('patient')->get();
    $patients = Patient::all(); 
    return view('orders', compact('orders', 'patients'));
});

// Simpan data order dari form
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
