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
        .alert-box {
            background: #fff8dc;
            border-left: 5px solid orange;
            padding: 15px;
            margin-bottom: 20px;
        }
        .alert-box strong {
            display: block;
        }
    </style>
</head>
<body>
    <h2 align="center">RUMAH SAKIT</h2>
    <h3 align="center">📦 Data Order (Pengobatan)</h3>

    <div class="nav" align="center">
        <a href="#form">➕ Tambah Order</a> |
        <a href="#data">📄 Lihat Tabel</a> |
        <a href="/patients-view">🔍 Data Pasien</a>
    </div>

    @if(session('success'))
        <p style="color: green; text-align: center;">{{ session('success') }}</p>
    @endif

    {{-- ✅ Rekomendasi & Peringatan --}}
    <div id="recommendation-box">
        @if (isset($analysis))
            <div class="alert-box">
                <strong>💡 Rekomendasi Obat:</strong> {{ $analysis['recommendation'] }}
                @if ($analysis['warning'])
                    <strong style="color: red;">{{ $analysis['warning'] }}</strong>
                @endif
            </div>
        @endif
    </div>

    <div id="form">
        <form action="/orders-store" method="POST">
            @csrf
            <h3>📝 Tambah Order Baru</h3>

            <label>Pasien:</label>
            <select name="patient_id" required onchange="updateRecommendation(this)">
                <option value="">-- Pilih Pasien --</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}" @if($patient->id == $selectedId) selected @endif>{{ $patient->name }}</option>
                @endforeach
            </select>

            <label>Nama Produk:</label>
            <input type="text" name="product_name" required id="product_name" oninput="updateRecommendationOnProductChange()">

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

    <script>
        // Fungsi untuk mengupdate rekomendasi berdasarkan pasien yang dipilih
        function updateRecommendation(selectElement) {
            var patientId = selectElement.value;
    
            // Mengirimkan ID pasien ke controller untuk mendapatkan rekomendasi
            if (patientId) {
                fetch(`/orders/recommendation/${patientId}`)
                    .then(response => response.json())
                    .then(data => {
                        var recommendationBox = document.getElementById('recommendation-box');
                        if (data.recommendation) {
                            recommendationBox.innerHTML = ` 
                                <div class="alert-box">
                                    <strong>💡 Rekomendasi Obat:</strong> ${data.recommendation}
                                    ${data.warning ? `<strong style="color: red;">${data.warning}</strong>` : ''}
                                </div>
                            `;
                        } else {
                            recommendationBox.innerHTML = '';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('recommendation-box').innerHTML = '';
            }
        }

        // Fungsi untuk update rekomendasi berdasarkan produk yang dipilih
        function updateRecommendationOnProductChange() {
            var patientId = document.querySelector('[name="patient_id"]').value;
            var productName = document.getElementById('product_name').value;
    
            // Periksa apakah produk dan pasien sudah dipilih
            if (patientId && productName) {
                fetch(`/orders/recommendation/${patientId}?product_name=${productName}`)
                    .then(response => response.json())
                    .then(data => {
                        var recommendationBox = document.getElementById('recommendation-box');
                        if (data.recommendation) {
                            recommendationBox.innerHTML = ` 
                                <div class="alert-box">
                                    <strong>💡 Rekomendasi Obat:</strong> ${data.recommendation}
                                    ${data.warning ? `<strong style="color: red;">${data.warning}</strong>` : ''}
                                </div>
                            `;
                        } else {
                            recommendationBox.innerHTML = '';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Menangani pemilihan pasien saat halaman pertama kali dimuat
        document.addEventListener("DOMContentLoaded", function() {
            var selectedPatientId = document.querySelector('[name="patient_id"]').value;
            if (selectedPatientId) {
                updateRecommendation(document.querySelector('[name="patient_id"]'));
            }
        });
    </script>
</body>
</html>
