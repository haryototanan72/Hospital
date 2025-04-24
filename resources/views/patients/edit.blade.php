<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-6 font-sans">

    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">📝 Edit Data Pasien</h2>

        <form action="{{ url('/patients/' . $patient->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="block mb-2 font-medium">Nama:</label>
            <input type="text" name="name" value="{{ $patient->name }}" required class="w-full p-2 border rounded mb-4">

            <label class="block mb-2 font-medium">Alamat:</label>
            <input type="text" name="address" value="{{ $patient->address }}" class="w-full p-2 border rounded mb-4">

            <label class="block mb-2 font-medium">No HP:</label>
            <input type="text" name="phone" value="{{ $patient->phone }}" class="w-full p-2 border rounded mb-4">

            <label class="block mb-2 font-medium">Keluhan:</label>
            <textarea name="complaint" class="w-full p-2 border rounded mb-4">{{ $patient->complaint }}</textarea>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition font-medium">
                💾 Simpan Perubahan
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="/patients" class="text-blue-600 hover:underline">⬅️ Kembali ke Data Pasien</a>
        </div>
    </div>

</body>
</html>
