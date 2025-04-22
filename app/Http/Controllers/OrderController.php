<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with('patient')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'product_name' => 'required|string',
            'quantity' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $order = Order::create($validated);

        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = Order::with('patient')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return $order;
    }
}
