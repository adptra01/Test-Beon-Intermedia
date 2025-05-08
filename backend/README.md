# 🏡 Aplikasi Iuran Warga RT - Backend (Laravel)

Aplikasi ini dibuat untuk membantu pengelolaan iuran dan pengeluaran bulanan di lingkungan perumahan yang dikelola oleh RT.

> Backend ini dibangun menggunakan Laravel dan MySQL, serta mendukung REST API yang siap diintegrasikan dengan frontend React.

---

## ✨ Fitur Utama

### 🔹 Pengelolaan Penghuni (Residents)
- Tambah, ubah, hapus penghuni
- Atribut:
  - Nama lengkap
  - Foto KTP
  - Status: tetap / kontrak
  - Nomor telepon
  - Status menikah

### 🔹 Pengelolaan Rumah (Houses)
- Tambah & ubah rumah
- Kelola penghuni rumah (history siapa pernah tinggal di rumah mana)
- Status rumah: dihuni / tidak dihuni
- Riwayat pembayaran tiap rumah & penghuni

### 🔹 Pembayaran Iuran Bulanan
- Iuran satpam (100k)
- Iuran kebersihan (15k)
- Pembayaran bisa bulanan atau sekaligus tahunan
- Status pembayaran: lunas / belum

### 🔹 Pengeluaran (Expenses)
- Pencatatan pengeluaran rutin (gaji satpam, token listrik) & tidak rutin (perbaikan)
- Kategori: gaji satpam, token listrik, perbaikan, lainnya

### 🔹 Laporan & Ringkasan
- Ringkasan pemasukan & pengeluaran bulanan (dalam bentuk grafik)
- Detail laporan per bulan

---

## 📦 Struktur Model & ERD (Singkat)

| Model           | Relasi Utama                           |
|-----------------|----------------------------------------|
| `User`          | Autentikasi (Sanctum)                  |
| `Resident`      | 1:M ke `HouseResident`, `Payment`      |
| `House`         | 1:M ke `HouseResident`, `Payment`      |
| `HouseResident` | many-to-one ke `House` dan `Resident`  |
| `Payment`       | many-to-one ke `House`, `Resident`     |
| `Expense`       | tidak terkait relasi luar              |

---

## ⚙️ Instalasi (Panduan Lengkap)

### 1. Clone Repository

```bash
git clone https://github.com/username/iuran-backend.git
cd iuran-backend
