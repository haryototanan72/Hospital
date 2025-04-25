<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-6 font-sans">

    <h2 class="text-2xl font-bold text-center mb-6">✏️ Edit Order</h2>

    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
        <form action="{{ url('/orders/' . $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="block mb-2">Pasien:</label>
            <select name="patient_id" required class="w-full p-2 border rounded mb-4">
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $order->patient_id == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>

            <label class="block mb-2">Nama Produk:</label>
            <input type="text" name="product_name" value="{{ $order->product_name }}" class="w-full p-2 border rounded mb-4">

            <label class="block mb-2">Jumlah:</label>
            <input type="number" name="quantity" value="{{ $order->quantity }}" class="w-full p-2 border rounded mb-4">

            <label class="block mb-2">Catatan:</label>
            <textarea name="note" class="w-full p-2 border rounded mb-4">{{ $order->note }}</textarea>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition font-medium">
                💾 Simpan Perubahan
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="/orders" class="text-blue-600 hover:underline">⬅️ Kembali ke Data Pasien</a>
        </div>
        </form>
    </div>

</body>
</html>
