# UNGS Warehouse Management System 📦

Sistem Manajemen Pergudangan UNGS adalah platform berbasis web untuk mengelola stok, inventaris, dan alur barang (Masuk/Keluar) dengan antarmuka modern yang dioptimalkan untuk efisiensi operasional.

## ✨ Fitur Utama
- **Dashboard Informatif**: Ringkasan stok, kategori, supplier, dan peringatan stok menipis secara real-time.
- **Manajemen Barang**: CRUD data barang lengkap dengan kode unik, kategori, dan satuan.
- **Manajemen Supplier**: Pengelolaan data mitra supplier beserta kategori barang yang disediakan.
- **Barang Keluar & Masuk**: Pencatatan transaksi stok dengan update otomatis ke jumlah inventaris.
- **Multi-Role Access**:
  - **Admin**: Akses penuh ke semua modul dan pengelolaan data master.
  - **Manajer**: Akses monitoring laporan stok dan profil personal.
- **Modern UI/UX**: Desain bertema **Sage Green** yang premium dengan landing page dan login page yang estetik.

## 🛠️ Tech Stack
- **Framework**: [Laravel 13](https://laravel.com)
- **Frontend**: Bootstrap 5, Vite, Bootstrap Icons
- **Language**: PHP 8.2+, Javascript
- **Font**: Inter (Google Fonts)

## 🚀 Cara Instalasi

### 1. Persiapan Environment
Pastikan Anda sudah menginstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database (MySQL/SQLite)

### 2. Clone & Install
```bash
# Clone repositori
git clone https://github.com/nexuzz14/warehouse-management.git
cd warehouse-management

# Install dependensi PHP
composer install

# Install dependensi Frontend
npm install
```

### 3. Konfigurasi
```bash
# Salin file .env
cp .env.example .env

# Generate aplikasi key
php artisan key:generate
```
*Sesuaikan pengaturan database di file `.env`.*

### 4. Database & Seeding
```bash
# Jalankan migrasi dan isi data awal
php artisan migrate --seed
```

### 5. Jalankan Aplikasi
Buka **dua terminal** terpisah:

**Terminal 1 (PHP Server):**
```bash
php artisan serve
```

**Terminal 2 (Vite Compiler):**
```bash
npm run dev
```
Akses aplikasi di: `http://127.0.0.1:8000`

---

## 🔑 Akun Uji Coba (Default)

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@ungs.com` | `password` |
| **Manajer** | `manajer@ungs.com` | `password` |

---

## 🎨 Filosofi Desain
Aplikasi ini menggunakan skema warna **Sage Green (#3d5442)** untuk memberikan kesan profesional, tenang, dan modern. Sidebar menggunakan logo melingkar sesuai standar branding terbaru UNGS.

## 📄 Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).
