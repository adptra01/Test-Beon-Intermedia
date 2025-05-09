# Iuran RT - Project Progress

## Backend Progress

# **Iuran RT - Backend (Laravel)**

## **Deskripsi Aplikasi**

Aplikasi backend ini dirancang untuk mendukung sistem administrasi RT, mencakup pengelolaan data penghuni, rumah, pembayaran iuran, dan pengeluaran operasional bulanan. Backend dibangun menggunakan **Laravel 10** dan mendukung dokumentasi API otomatis menggunakan **Swagger (L5 Swagger)**.

---

## **Fitur Utama**

* CRUD untuk:

  * Penghuni (`residents`)
  * Rumah (`houses`)
  * Hubungan rumah-penghuni (`house_residents`)
  * Pembayaran (`payments`)
  * Pengeluaran (`expenses`)
* Autentikasi pengguna menggunakan **Laravel Sanctum**
* Dokumentasi API otomatis dengan **Swagger (L5 Swagger)**
* Validasi berbasis **Form Request**
* Struktur API Resourceful yang konsisten

---

## **Teknologi & Dependensi Utama**

### `require`

```json
"php": "^8.1",
"laravel/framework": "^10.10",
"laravel/sanctum": "^3.3",
"guzzlehttp/guzzle": "^7.2",
"infyomlabs/laravel-generator": "^6.0",
"infyomlabs/adminlte-templates": "^6.0",
"darkaonline/l5-swagger": "8.*",
"infyomlabs/swagger-generator": "^3.0"
```

### `require-dev`

```json
"fakerphp/faker": "^1.9.1",
"phpunit/phpunit": "^10.1",
"laravel/pint": "^1.0",
"nunomaduro/collision": "^7.0",
"spatie/laravel-ignition": "^2.0"
```

> 🔧 Dokumentasi API otomatis dihasilkan oleh **L5 Swagger** (`/api/documentation`)

---

## **Instalasi & Setup**

### 1. Clone Repositori

```bash
git clone https://github.com/username/iuran-rt-backend.git
cd iuran-rt-backend
```

### 2. Instal Dependensi

```bash
composer install
```

### 3. Konfigurasi `.env`

```bash
cp .env.example .env
php artisan key:generate
```

Atur koneksi database di `.env`.

### 4. Migrasi & Seeding

```bash
php artisan migrate --seed
```

### 5. Jalankan Server

```bash
php artisan serve
```

---

## **Dokumentasi API dengan Swagger**

Swagger otomatis menghasilkan dokumentasi dari anotasi `@OA` yang ditulis di controller.
Setelah setup berhasil, akses dokumentasi melalui:

```
http://localhost:8000/api/documentation
```

Jika belum tersedia, generate dokumentasi dengan:

```bash
php artisan l5-swagger:generate
```

---

## **Struktur CRUD API**

| Resource       | Endpoint               | Keterangan                |
| -------------- | ---------------------- | ------------------------- |
| Residents      | `/api/residents`       | CRUD data penghuni        |
| Houses         | `/api/houses`          | CRUD data rumah           |
| HouseResidents | `/api/house-residents` | Relasi rumah dan penghuni |
| Payments       | `/api/payments`        | Data pembayaran bulanan   |
| Expenses       | `/api/expenses`        | Data pengeluaran bulanan  |

---

## **Autentikasi API (Sanctum)**

| Endpoint        | Method | Deskripsi              |
| --------------- | ------ | ---------------------- |
| `/api/register` | POST   | Registrasi pengguna    |
| `/api/login`    | POST   | Login pengguna         |
| `/api/logout`   | POST   | Logout (auth\:sanctum) |
| `/api/user`     | GET    | Ambil user yang login  |

> Pastikan frontend memanggil `/sanctum/csrf-cookie` sebelum login/logout saat menggunakan SPA.

---

## ✅ Tips Penggunaan Swagger

* Tambahkan anotasi `@OA` di setiap controller API (lihat dokumentasi L5 Swagger)
* Gunakan command:

  ```bash
  php artisan l5-swagger:generate
  ```

---

## Lisensi

Proyek ini dikembangkan untuk keperluan seleksi dan pembelajaran.

---

## Frontend Progress

### 1. Mengelola Penghuni (Residents)

- Fitur ini sudah sepenuhnya diimplementasikan di frontend.
- Mendukung penambahan, pengubahan, dan penghapusan data penghuni.
- Atribut penghuni meliputi:
  - Nama lengkap
  - Foto KTP
  - Status penghuni (kontrak/tetap)
  - Nomor telepon
  - Status menikah
- Halaman Penghuni menampilkan daftar penghuni dengan atribut tersebut dan mendukung operasi CRUD dengan validasi form.

### 2. Mengelola Rumah (Houses)

- Belum ditemukan implementasi fitur ini di frontend.
- Fitur yang belum ada meliputi penambahan/pengubahan rumah, pengelolaan penghuni rumah, catatan historis penghuni, riwayat pembayaran, dan status rumah (dihuni/tidak dihuni).

### 3. Mengelola Pembayaran (Payments)

- Belum ditemukan implementasi fitur ini di frontend.
- Fitur yang belum ada meliputi penambahan data pembayaran, pengelolaan iuran bulanan dan tahunan, serta laporan pemasukan dan pengeluaran.

---

Jika Anda ingin, saya dapat membantu merencanakan atau memulai implementasi fitur yang belum ada, atau memeriksa dukungan backend untuk fitur-fitur tersebut.
