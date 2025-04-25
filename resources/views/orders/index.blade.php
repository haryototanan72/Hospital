<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-6 font-sans">

    <h2 class="text-3xl font-bold text-center mb-2">RUMAH SAKIT</h2>
    <h3 class="text-xl text-center mb-6">📦 Data Order (Pengobatan)</h3>

    <div class="flex justify-center gap-4 mb-6 text-blue-600 font-medium">
        <a href="#form" class="hover:underline">➕ Tambah Order</a>
        <span>|</span>
        <a href="#data" class="hover:underline">📄 Lihat Tabel</a>
        <span>|</span>
        <a href="{{ url('/patients') }}" class="hover:underline">🔍 Data Pasien</a>
    </div>

    @if(session('success'))
        <p class="text-green-600 text-center mb-4">{{ session('success') }}</p>
    @endif

    {{-- 🔍 Dropdown pasien untuk rekomendasi --}}
    <form method="GET" action="{{ url('/orders') }}" class="max-w-xl mx-auto mb-6">
        <label for="patient_id" class="block mb-2 font-medium">Pilih Pasien untuk Order:</label>
        <select name="patient_id" onchange="this.form.submit()" class="w-full p-2 border rounded">
            <option value="">-- Pilih Pasien --</option>
            @foreach ($patients as $patient)
                <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                    {{ $patient->name }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- ✅ FORM TAMBAH ORDER --}}
    @if (request('patient_id'))
        @php
            $selectedId = request('patient_id');
            $selectedPatient = $patients->find($selectedId);
        @endphp

        <div id="form" class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow mb-10">
            <h3 class="text-lg font-semibold mb-4">📝 Tambah Order Baru</h3>

            {{-- 💡 Informasi Keluhan & Rekomendasi --}}
            @if (isset($analysis) && $selectedPatient)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded mb-6">
                    <p><strong>🧍 Pasien:</strong> {{ $selectedPatient->name }}</p>
                    @if ($selectedPatient->complaint)
                        <p><strong>📋 Keluhan:</strong> {{ $selectedPatient->complaint }}</p>
                    @endif
                    <p><strong>💊 Rekomendasi Obat:</strong> {{ $analysis['recommendation'] }}</p>
                    @if (!empty($analysis['warning']))
                        <p class="text-red-600 mt-2"><strong>⚠️ {{ $analysis['warning'] }}⚠️</strong></p>
                    @endif
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <input type="hidden" name="patient_id" value="{{ $selectedId }}">

                <label class="block mb-2 font-medium">Nama Produk:</label>
                <input type="text" name="product_name" required class="w-full p-2 border rounded mb-4">

                <label class="block mb-2 font-medium">Jumlah:</label>
                <input type="number" name="quantity" required class="w-full p-2 border rounded mb-4">

                <label class="block mb-2 font-medium">Catatan:</label>
                <textarea name="note" class="w-full p-2 border rounded mb-4"></textarea>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition font-medium">
                    💾 Simpan
                </button>
            </form>
        </div>
    @endif

    {{-- 📄 Tabel order --}}
    <div id="data" class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded-lg shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 border">ID</th>
                    <th class="py-3 px-4 border">Pasien</th>
                    <th class="py-3 px-4 border">Produk</th>
                    <th class="py-3 px-4 border">Jumlah</th>
                    <th class="py-3 px-4 border">Catatan</th>
                    <th class="py-3 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border">{{ $order->id }}</td>
                        <td class="py-2 px-4 border">{{ $order->patient->name ?? 'Tidak Ditemukan' }}</td>
                        <td class="py-2 px-4 border">{{ $order->product_name }}</td>
                        <td class="py-2 px-4 border">{{ $order->quantity }}</td>
                        <td class="py-2 px-4 border">{{ $order->note }}</td>
                        <td class="py-2 px-4 border">
                            <div class="flex gap-3 justify-center">
                                <a href="{{ url('/orders/' . $order->id . '/edit') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">✏️ Edit</a>
                                <form action="{{ url('/orders/' . $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus order ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">🗑️ Delete</button>
                                </form>
                            </div>
                        </td>                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
