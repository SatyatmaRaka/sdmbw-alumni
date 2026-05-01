# SDMBW Alumni Dashboard 🎓

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js)](https://vuejs.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)](https://php.net)

**SDMBW Alumni Dashboard** adalah Sistem Informasi Manajemen Alumni & *Tracer Study* terpadu yang dikembangkan khusus untuk **SD Muhammadiyah Birrul Walidain Kudus**. Sistem ini berfungsi sebagai basis data tunggal untuk memantau perkembangan alumni, memvalidasi data lulusan, dan menghasilkan laporan statistik yang akurat bagi pihak sekolah.

---

## 🏛️ Arsitektur & Teknologi

Sistem ini menggunakan pendekatan **Hybrid Modern Architecture**:
- **Core Engine:** Laravel 12 dengan PHP 8.2+.
- **Frontend Hybrid:** 
  - **Blade Engine:** Digunakan untuk struktur halaman utama, layouts, dan SEO-friendly routing.
  - **Vue.js 3 (Composition API):** Digunakan untuk komponen interaktif tingkat tinggi (Dynamic Forms, Interactive Charts, Real-time Filters).
  - **Tailwind CSS 4:** Framework CSS utama untuk *styling* yang modern dan responsif.
  - **Vite:** Sebagai *frontend build tool* untuk performa maksimal.

---

## ✨ Fitur Utama Sistem

### 1. Tracer Study & Profiling (Modul Alumni)
- **Onboarding Terstruktur:** Alumni wajib melengkapi data profil dan riwayat setelah verifikasi.
- **Pendidikan Terintegrasi:** Pelacakan riwayat pendidikan lanjutan (SMP, SMA, Perguruan Tinggi).
- **Rekam Jejak Pekerjaan:** Pendataan karir alumni untuk kebutuhan statistik sekolah.
- **Mandatory Testimonial:** Sistem mengharuskan alumni mengisi kesan & pesan setelah profil lengkap sebagai bagian dari keterlibatan komunitas.
- **Direktori Publik & Internal:** Pencarian alumni berbasis angkatan dengan filter yang cepat.

### 2. High-Level Administration (Modul Admin)
- **Dashboard Statistik Interaktif:** Ringkasan data angkatan dan status alumni dalam bentuk grafik (Chart.js).
- **Smart Verification:** Sistem persetujuan akun pendaftar baru (Approve/Reject/Pending).
- **Excel Data Management:** 
  - **Mass Import:** Menambah ribuan data alumni sekaligus melalui template Excel.
  - **Dynamic Export:** Mengunduh data alumni ke format Excel untuk kebutuhan laporan dinamis.
- **Tracer Study Reporting:** Pembuatan laporan per angkatan yang siap saji.
- **CMS Control:** Manajemen FaQ dan Testimoni yang tampil di halaman depan.

### 3. Keamanan & Audit (Enterprise Grade)
- **Comprehensive Audit Logs:** Mencatat setiap aktivitas admin (siapa melakukan apa, kepada siapa, dan kapan) secara mendetail (Log Verifikasi, Reset Password, Hapus Data, dll).
- **Role-Based Access Control (RBAC):** Pemisahan hak akses yang ketat antara Super Admin dan Alumni.
- **Security Protocols:** Perlindungan terhadap CSRF, XSS, dan *Brute Force Attack* melalui *rate limiting*.

---

## 📁 Struktur Data Penting (Models)

Sistem didukung oleh struktur database yang relasional dan optimal:
- `Alumni`: Data induk profil alumni.
- `AlumniPendidikan`: Riwayat studi lanjut.
- `AlumniPekerjaan`: Riwayat karir/pekerjaan.
- `AdminLog`: Sistem pencatatan audit trail admin.
- `Angkatan`: Manajemen data tahun kelulusan.
- `Testimoni` & `Faq`: Konten dinamis landing page.

---

## 🚀 Panduan Instalasi Lokal

### 1. Persiapan Environment
Pastikan Anda memiliki PHP 8.2+, Composer, Node.js, dan MySQL terinstal di sistem Anda.

### 2. Instalasi Proyek
```bash
# Clone repository
git clone https://github.com/Rakawiratama/sdmbw-alumni.git
cd sdmbw-alumni

# Install dependency
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
```

### 3. Database & Seeding
```bash
# Buat database di MySQL (contoh: sdmbw_alumni)
# Jalankan migrasi dan data awal
php artisan migrate --seed
```

### 4. Menjalankan Server
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite Compiler
npm run dev
```

---

## 🔒 Akun Default (Seeder)
- **Admin:** `admin@example.com` / `password`
- **Alumni (Contoh):** Gunakan NISN yang terdaftar saat seeding atau daftar melalui halaman registrasi.

---

## 📝 Catatan Pengembangan
Sistem ini dikembangkan dengan prinsip *clean code* dan *service layer pattern* untuk memastikan skalabilitas jangka panjang bagi SD Muhammadiyah Birrul Walidain Kudus.

**Developer:** [Rakawiratama](https://github.com/Rakawiratama)
