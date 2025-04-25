# Sistem Manajemen Rumah Sakit – UTS MK EAI

Sistem Manajemen Rumah Sakit ini dirancang untuk membantu pengelolaan data pasien dan transaksi penggunaan produk medis secara efisien. Aplikasi ini dibangun menggunakan framework Laravel dengan integrasi database MySQL serta dukungan REST API. Antarmuka pengguna dibuat menggunakan Blade View untuk memudahkan input dan visualisasi data secara real-time melalui browser.

---

##  Fitur Sistem

-  Menyimpan dan menampilkan data **pasien**
-  Menyimpan dan menampilkan data **order (transaksi penggunaan produk medis)**
-  Relasi pasien ↔ order
-  Input data melalui form web dan API
-  Tabel visualisasi data
-  Validasi dan notifikasi sukses

---

##  Teknologi yang Digunakan

| Komponen   | Teknologi          |
|------------|--------------------|
| Backend    | Laravel 11         |
| Database   | MySQL              |
| API Format | REST (JSON)        |
| Frontend   | Blade View (HTML)  |
| Local Dev  | `php artisan serve` |

---

##  Daftar API

###  Pasien

| Method | Endpoint               | Deskripsi                    |
|--------|------------------------|------------------------------|
| GET    | `/api/patients`        | Menampilkan semua pasien     |
| POST   | `/api/patients`        | Menambahkan pasien baru      |
| GET    | `/api/patients/{id}`   | Menampilkan detail pasien    |

###  Order

| Method | Endpoint              | Deskripsi                   |
|--------|-----------------------|-----------------------------|
| GET    | `/api/orders`         | Menampilkan semua order     |
| POST   | `/api/orders`         | Menambahkan order baru      |
| GET    | `/api/orders/{id}`    | Menampilkan detail order    |

---

##  Tampilan Web (Blade View)

| Halaman       | URL                   | Fungsi                          |
|---------------|------------------------|----------------------------------|
| Data Pasien   | `/patients-view`       | Lihat & tambah data pasien      |
| Data Order    | `/orders-view`         | Lihat & tambah order pasien     |

---

##  Contoh Request API

### Tambah Pasien
**POST** `/api/patients`
```json
{
  "name": "Andi",
  "address": "Jl. Cempaka",
  "phone": "081234567890",
  "complaint": "Sakit kepala"
}
--- 

 ### Tambah Orders
**POST** `/api/Orders`
```json
{
  "patient_id": 1,
  "product_name": "Paracetamol",
  "quantity": 2,
  "note": "Untuk demam"
}
--- 
SS
#Struktur Tabel Database
patients
id (BIGINT)

name (VARCHAR)

address (VARCHAR)

phone (VARCHAR)

complaint (TEXT)

orders
id (BIGINT)

patient_id (FK)

product_name (VARCHAR)

quantity (INT)

note (TEXT)

 Status Pengujian
 Tambah pasien (via form & API)

 Tambah order (via form & API)

 Relasi pasien ke order

 Tabel visualisasi data

 Validasi input

 Navigasi antartampilan

### Disusun Oleh
Kelompok 7 
Nama : [Ailsya Frederica Aldora]
Nama : [Benedict David Prasetyo]
Nama : [Haryo Nugrah Putra Totanan]

Prodi : [S1 Sistem Informasi]

Kampus : [Telkom University]

Tahun : 2025

 Catatan Tambahan
Sistem ini dirancang agar mudah diuji dan digunakan baik melalui browser maupun alat seperti Postman. Antarmuka dibuat ringan untuk menjaga kecepatan dan kenyamanan penggunaan. Rute API didefinisikan di routes/api.php, sedangkan tampilan web berada di routes/web.php.
