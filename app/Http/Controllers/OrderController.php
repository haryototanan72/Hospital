<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Patient;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data order dan pasien
        $orders = Order::with('patient')->get();
        $patients = Patient::all();

        // Ambil ID pasien yang dipilih dari query string
        $selectedId = $request->query('patient_id');
        $selectedPatient = $selectedId ? Patient::find($selectedId) : $patients->first();

        // Jika pasien yang dipilih tidak ditemukan, fallback ke pasien pertama
        if (!$selectedPatient) {
            return redirect('/orders')->with('error', 'Pasien tidak ditemukan.');
        }

        $analysis = null;
        if ($selectedPatient) {
            // Ambil rekomendasi dan peringatan berdasarkan pasien yang dipilih
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

    // ✅ Fungsi tambahan: Rekomendasi dan peringatan
    public function getRecommendation($patientId)
    {
        $patient = Patient::find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }

        // Mendapatkan rekomendasi dan peringatan untuk pasien
        $analysis = $this->getRecommendationAndWarning($patient);

        return response()->json($analysis);
    }

    // ✅ Fungsi untuk mendapatkan rekomendasi dan peringatan
    public function getRecommendationAndWarning(Patient $patient)
    {
        $recommendation = "Konsultasi lebih lanjut.";
        $warning = null;

        // Rekomendasi obat berdasarkan keluhan
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

        // Analisis ketergantungan
        $lastOrders = Order::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        if ($lastOrders->count() >= 3) {
            $obat = $lastOrders->pluck('product_name')->unique();
            $jumlah = $lastOrders->pluck('quantity');

            if ($obat->count() === 1 && $jumlah->sort()->values()->toArray() === $jumlah->toArray()) {
                $warning = "⚠️ Pasien ini mungkin mengalami ketergantungan terhadap obat: " . $obat->first();
            }
        }

        // Mengembalikan data rekomendasi dan peringatan dalam format array
        return [
            'recommendation' => $recommendation,
            'warning' => $warning,
        ];
    }
}
