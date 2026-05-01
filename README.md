# SDMBW Alumni Dashboard 🎓

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js)](https://vuejs.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)](https://php.net)

**SDMBW Alumni Dashboard** adalah platform manajemen alumni modern yang dirancang khusus untuk **SD Muhammadiyah Birrul Walidain Kudus**. Sistem ini berfungsi sebagai pusat data terintegrasi untuk mendukung administrasi sekolah, pelaporan, dan menjaga komunikasi jangka panjang dengan para alumni.

---

## 📌 Deskripsi Proyek

Aplikasi ini menggantikan sistem pendataan konvensional yang manual dengan solusi digital yang efisien. Alumni dapat mengelola profil mereka secara mandiri, sementara sekolah memiliki kontrol penuh untuk memverifikasi dan memantau data secara akurat.

### 🎯 Tujuan Utama
- **Database Terstruktur:** Menjamin ketersediaan data alumni yang rapi dan selalu diperbarui.
- **Validitas Tinggi:** Proses verifikasi admin memastikan hanya data valid yang masuk ke sistem.
- **Efisiensi Kerja:** Otomatisasi pembuatan laporan dan statistik alumni.
- **Jembatan Komunikasi:** Memudahkan sekolah menjangkau alumni untuk informasi atau kegiatan sekolah.

---

## 🛠️ Tech Stack

### Backend
- **Framework:** Laravel 12 (Stable)
- **Language:** PHP 8.2 / 8.3
- **Database:** MySQL / MariaDB
- **Auth:** Laravel Breeze / Fortify (Session Based)

### Frontend
- **Engine:** Vue.js 3 (Composition API)
- **Styling:** Tailwind CSS 4 & Bootstrap 5 (Hybrid Setup)
- **Bundler:** Vite
- **Charts:** Chart.js with Vue-Chartjs

---

## ✨ Fitur Utama

- 🔐 **Autentikasi Aman:** Login & Registrasi berbasis NISN dengan validasi ganda.
- 📊 **Smart Dashboard:** Ringkasan status akun dan progres kelengkapan profil.
- 👤 **Self-Service Profil:** Update data pendidikan, pekerjaan, dan kontak secara mandiri.
- 📂 **Direktori Alumni:** Pencarian alumni dengan filter angkatan yang responsif.
- 🛡️ **Powerful Admin Panel:** 
  - Verifikasi pendaftar baru.
  - Manajemen master data (Angkatan, Kelas, Pekerjaan).
  - Monitoring log aktivitas sistem.
- 📈 **Visualisasi Data:** Grafik statistik alumni menggunakan Chart.js.
- 📱 **Responsive Design:** Pengalaman pengguna yang mulus di HP maupun Desktop.

---

## 🚀 Panduan Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Server

### Langkah-langkah

1. **Clone Repository**
   ```bash
   git clone https://github.com/Rakawiratama/sdmbw-alumni.git
   cd sdmbw-alumni
   ```

2. **Instalasi Dependency PHP**
   ```bash
   composer install
   ```

3. **Instalasi Dependency JavaScript**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Jangan lupa sesuaikan pengaturan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di file `.env`.*

5. **Migrasi Database & Seeding**
   ```bash
   php artisan migrate --seed
   ```

6. **Menjalankan Project**
   Buka dua terminal:
   - Terminal 1 (Laravel): `php artisan serve`
   - Terminal 2 (Vite): `npm run dev`

7. **Akses Aplikasi**
   Buka [http://127.0.0.1:8000](http://127.0.0.1:8000) di browser Anda.

---

## 🔄 Alur Kerja Sistem

1. **Registrasi:** Alumni mendaftar menggunakan NISN.
2. **Lengkapi Data:** Mengisi detail profil (Pendidikan Terakhir, Pekerjaan, Alamat).
3. **Verifikasi:** Admin memeriksa validitas data di Dashboard Admin.
4. **Verified:** Setelah disetujui, profil alumni akan muncul di direktori publik/internal.

---

## 🔒 Keamanan
- **CSRF Protection:** Mencegah serangan cross-site.
- **Bcrypt Hashing:** Keamanan password tingkat tinggi.
- **Role Management:** Pemisahan ketat akses Admin vs Alumni.
- **Input Sanitization:** Validasi ketat di semua layer input.

---

## 🗺️ Roadmap
- [x] Manajemen Profil Dasar
- [x] Dashboard Admin & Statistik
- [ ] Export Data ke PDF/Excel
- [ ] Integrasi Notifikasi WhatsApp/Email
- [ ] Sistem Pengumuman Terpusat

---

## 📝 Lisensi
Proyek ini dikembangkan untuk kepentingan SD Muhammadiyah Birrul Walidain Kudus.

**Dikembangkan oleh:** [Rakawiratama](https://github.com/Rakawiratama)
