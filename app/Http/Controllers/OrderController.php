<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Patient;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('patient')->get();
        $patients = Patient::all();

        $selectedId = $request->query('patient_id');
        $selectedPatient = $selectedId ? Patient::find($selectedId) : $patients->first();

        if (!$selectedPatient) {
            return redirect('/orders')->with('error', 'Pasien tidak ditemukan.');
        }

        $analysis = null;
        if ($selectedPatient) {
            $analysis = $this->getRecommendationAndWarning($selectedPatient);
        }

        return view('orders.index', compact('orders', 'patients', 'analysis', 'selectedId'));
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
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
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

    public function getRecommendation($patientId)
    {
        $patient = Patient::find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }

        $analysis = $this->getRecommendationAndWarning($patient);
        return response()->json($analysis);
    }

    public function getRecommendationAndWarning(Patient $patient)
    {
        $recommendation = "Konsultasi lebih lanjut.";
        $warning = null;

        // Rekomendasi berdasarkan keluhan
        $complaint = strtolower($patient->complaint ?? '');
        if (str_contains($complaint, 'demam')) {
            $recommendation = 'Paracetamol';
        } elseif (str_contains($complaint, 'batuk')) {
            $recommendation = 'OBH';
        } elseif (str_contains($complaint, 'flu')) {
            $recommendation = 'Dextromethorphan';
        } elseif (str_contains($complaint, 'sakit kepala')) {
            $recommendation = 'Panadol';
        }

        // Analisis order terakhir
        $lastOrders = Order::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Grouping berdasarkan nama produk
        $grouped = $lastOrders->groupBy('product_name');

        foreach ($grouped as $product => $orders) {
            $quantities = $orders->pluck('quantity')->values();

            // Cek jika jumlah pemesanan meningkat terus
            if ($orders->count() >= 3 && $quantities->sort()->values()->toArray() === $quantities->toArray()) {
                $warning = "⚠️ Pasien mungkin mengalami ketergantungan terhadap obat: $product karena jumlahnya terus meningkat.⚠️";
                break;
            }

            // Cek jika salah satu order sudah melebihi 10
            if ($quantities->max() > 10) {
                $warning = "⚠️ Ditemukan indikasi ketergantungan pada obat: $product karena jumlah melebihi batas wajar.⚠️";
                break;
            }
        }

        return [
            'recommendation' => $recommendation,
            'warning' => $warning,
        ];
    }
}
