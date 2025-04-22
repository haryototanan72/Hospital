# 📘 Dokumentasi API – Sistem Manajemen Rumah Sakit

## ✅ Informasi Umum
Base URL: `http://localhost:8000/api`

---

## 👨‍⚕️ Pasien (Patient)

### ➕ Tambah Pasien
- **Endpoint:** `POST /patients`
- **Body JSON:**
```json
{
  "name": "Andi",
  "address": "Jl. Cempaka",
  "phone": "081234567890",
  "complaint": "Demam dan batuk"
}
