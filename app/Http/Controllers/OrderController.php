<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Patient;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('patient')->get();
        $patients = Patient::all();
        return view('orders.index', compact('orders', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'product_name' => 'required|string',
            'quantity' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        Order::create($validated);

        return redirect('/orders')->with('success', 'Order berhasil ditambahkan.');
    }

    public function show($id)
    {
        $order = Order::with('patient')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $patients = Patient::all();
        return view('orders.edit', compact('order', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'product_name' => 'required|string',
            'quantity' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        return redirect('/orders')->with('success', 'Order berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return redirect('/orders')->with('success', 'Order berhasil dihapus.');
    }
}
