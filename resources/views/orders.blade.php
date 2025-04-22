<!DOCTYPE html>
<html>
<head>
    <title>Data Order</title>
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
        input, textarea, select {
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
    <h3 align="center">📦 Data Order (Pengobatan)</h3>

    <div class="nav" align="center">
        <a href="#form">➕ Tambah Order</a> |
        <a href="#data">📄 Lihat Tabel</a>
        <a href="/patients-view">🔍 Data Pasien</a>
    </div>

    @if(session('success'))
        <p style="color: green; text-align: center;">{{ session('success') }}</p>
    @endif

    <div id="form">
        <form action="/orders-store" method="POST">
            @csrf
            <h3>📝 Tambah Order Baru</h3>

            <label>Pasien:</label>
            <select name="patient_id" required>
                <option value="">-- Pilih Pasien --</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>

            <label>Nama Produk:</label>
            <input type="text" name="product_name" required>

            <label>Jumlah:</label>
            <input type="number" name="quantity" required>

            <label>Catatan:</label>
            <textarea name="note"></textarea>

            <button type="submit">Simpan</button>
        </form>
    </div>

    <div id="data">
        <table>
            <tr>
                <th>ID</th>
                <th>Pasien</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Catatan</th>
            </tr>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->patient->name ?? 'Tidak Ditemukan' }}</td>
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->note }}</td>
                </tr>
            @endforeach
        </table>
    </div>

</body>
</html>
