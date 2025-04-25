<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-6 font-sans">

    <h2 class="text-3xl font-bold text-center mb-2">RUMAH SAKIT</h2>
    <h3 class="text-xl text-center mb-6">📋 Data Pasien</h3>

    <div class="flex justify-center gap-4 mb-6 text-blue-600 font-medium">
        <a href="#form" class="hover:underline">➕ Tambah Pasien</a>
        <span>|</span>
        <a href="#data" class="hover:underline">📄 Lihat Tabel Data Pasien</a>
        <span>|</span>
        <a href="/orders" class="hover:underline">📦 Data Order</a>
    </div>

    @if(session('success'))
        <p class="text-green-600 text-center mb-4">{{ session('success') }}</p>
    @endif

    <div id="form" class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow mb-10">
        <form action="/patients-store" method="POST">
            @csrf
            <h3 class="text-lg font-semibold mb-4">📝 Tambah Pasien Baru</h3>

            <label class="block mb-2">Nama:</label>
            <input type="text" name="name" required class="w-full p-2 border rounded mb-4">

            <label class="block mb-2">Alamat:</label>
            <input type="text" name="address" class="w-full p-2 border rounded mb-4">

            <label class="block mb-2">No HP:</label>
            <input type="text" name="phone" class="w-full p-2 border rounded mb-4">

            <label class="block mb-2">Keluhan:</label>
            <textarea name="complaint" class="w-full p-2 border rounded mb-4"></textarea>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition font-medium">
                💾 Simpan
            </button>
                  
        </form>
    </div>

    <div id="data" class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded-lg shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 border">ID</th>
                    <th class="py-3 px-4 border">Nama</th>
                    <th class="py-3 px-4 border">Alamat</th>
                    <th class="py-3 px-4 border">No HP</th>
                    <th class="py-3 px-4 border">Keluhan</th>
                    <th class="py-3 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border">{{ $patient->id }}</td>
                        <td class="py-2 px-4 border">{{ $patient->name }}</td>
                        <td class="py-2 px-4 border">{{ $patient->address }}</td>
                        <td class="py-2 px-4 border">{{ $patient->phone }}</td>
                        <td class="py-2 px-4 border">{{ $patient->complaint }}</td>
                        <td class="py-2 px-4 border text-center">
                            <div class="inline-flex gap-3 justify-center">
                                <a href="{{ url('/patients/' . $patient->id . '/edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ url('/patients/' . $patient->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600 transition">
                                        🗑️ Delete
                                    </button>
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
