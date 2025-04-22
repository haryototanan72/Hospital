<!DOCTYPE html>
<html>
<head>
    <title>Data Pasien</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 30px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #aaa;
        }
        form {
            margin-bottom: 30px;
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        .nav {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h2 align="center">RUMAH SAKIT</h2>
    <h3 align="center">📋 Data Pasien</h3>

    <div class="nav" align="center">
        <a href="#form">➕ Tambah Pasien</a> |
        <a href="#data">📄 Lihat Tabel Data Pasien</a>
        <a href="/orders-view">📦 Data Order</a>
                
    </div>

    @if(session('success'))
        <p style="color: green; text-align: center;">{{ session('success') }}</p>
    @endif

    <div id="form">
        <form action="/patients-store" method="POST">
            @csrf
            <h3>📝 Tambah Pasien Baru</h3>
            <label>Nama:</label>
            <input type="text" name="name" required>

            <label>Alamat:</label>
            <input type="text" name="address">

            <label>No HP:</label>
            <input type="text" name="phone">

            <label>Keluhan:</label>
            <textarea name="complaint"></textarea>

            <button type="submit">Simpan</button>
        </form>
    </div>

    <div id="data">
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Keluhan</th>
            </tr>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->address }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->complaint }}</td>
                </tr>
            @endforeach
        </table>
    </div>

</body>
</html>
