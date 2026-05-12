# SPP Bersama - Sistem Informasi Pembayaran SPP Sekolah

![SPP Bersama](https://img.shields.io/badge/Laravel-10.x-FF2D20.svg?style=for-the-badge&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

**SPP Bersama** adalah sebuah aplikasi berbasis web yang dibangun untuk memudahkan pihak sekolah (Admin & Petugas) dalam mengelola dan mencatat data pembayaran Sumbangan Pembinaan Pendidikan (SPP) siswa. Aplikasi ini juga memberikan transparansi kepada Siswa untuk memantau status pembayaran mereka secara *real-time*.

Aplikasi ini didesain dengan antarmuka pengguna (UI) yang modern, responsif, dan dinamis, serta mengutamakan pengalaman pengguna (UX) yang optimal melalui penggunaan animasi transisi, layout yang terstruktur, dan fitur *wizard* interaktif. 

**DEMO: https://syahfalah.pplg1.my.id**
User Login:
1. Siswa (nisn *12345*)
2. Petugas (username *petugas*)
3. Administrator (username *admin*)
**User Password: password**

---

## ✨ Fitur Utama

### 🔐 Multi-Role Authentication
Sistem ini menggunakan autentikasi yang terpisah berdasarkan peran (*role*):
1. **Admin**: Memiliki hak akses penuh ke seluruh sistem (Kelola Data Master, Transaksi, Laporan).
2. **Petugas**: Dapat mengakses dashboard dan melakukan transaksi entri pembayaran.
3. **Siswa**: Memiliki portal khusus untuk memantau riwayat pembayaran dan tagihan.

### 🏛️ Modul Kelola Data (Master Data)
- **Data Siswa**: Manajemen data siswa lengkap dengan NIS, NISN, dan relasi ke Kelas & tarif SPP.
- **Data Kelas**: Manajemen data kelas beserta kompetensi keahlian.
- **Data SPP**: Manajemen tarif SPP berdasarkan tahun ajaran.
- **Data Petugas**: Manajemen pengguna sistem (Admin & Petugas).

### 💳 Modul Pembayaran (Smart Wizard)
Proses entri pembayaran dirombak menjadi *3-Step Wizard* yang intuitif menggunakan teknologi AJAX & Alpine.js:
- **Step 1:** Pilih Kelas (Menampilkan grid kelas beserta jumlah siswa).
- **Step 2:** Pilih Siswa (Daftar siswa dalam kelas dengan fitur pencarian *real-time*).
- **Step 3:** Form Pembayaran (Menampilkan tagihan otomatis, bulan yang sudah dilunasi ter-disable, dan hitungan jumlah bayar).

### 📊 Laporan & Cetak Bukti
- Generate laporan pembayaran dengan filter.
- Cetak bukti transaksi pembayaran per siswa.

### 🎓 Dashboard Siswa
Portal khusus siswa yang menampilkan:
- Profil lengkap siswa.
- Ringkasan Finansial: Total tagihan yang harus dibayar, tagihan jatuh tempo, dan total yang telah dibayarkan.
- Riwayat transaksi pembayaran terakhir.

---

## 🛠️ Teknologi yang Digunakan

- **Backend:** [Laravel](https://laravel.com/) (PHP Framework)
- **Frontend:** HTML5, Blade Templating Engine
- **Styling:** [Tailwind CSS](https://tailwindcss.com/) (Utility-first CSS framework)
- **Reactivity & Interactivity:** [Alpine.js](https://alpinejs.dev/) (Lightweight JavaScript framework)
- **Database:** MySQL
- **Iconography:** SVG Icons (Heroicons & Custom)

---

## 🚀 Cara Instalasi & Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal Anda:

### Prasyarat
Pastikan komputer Anda sudah terinstall:
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL Database (seperti XAMPP / Laragon)

### Langkah Instalasi

1. **Clone Repository (atau copy folder project)**
   Pastikan Anda berada di direktori server lokal (misal: `htdocs` untuk XAMPP atau `www` untuk Laragon).

2. **Install Dependensi Backend (PHP/Laravel)**
   Buka terminal di dalam direktori project dan jalankan:
   ```bash
   composer install
   ```

3. **Install Dependensi Frontend (Node.js/Tailwind)**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Duplikat file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan atur konfigurasi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_spp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi & Seeding Database**
   Jalankan migrasi untuk membuat tabel beserta data dummy (akun default):
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Compile Assets (Tailwind & JavaScript)**
   Jalankan Vite untuk meng-compile asset CSS dan JS:
   ```bash
   npm run build
   ```
   *(Atau gunakan `npm run dev` jika Anda ingin melakukan pengembangan/perubahan tampilan).*

8. **Jalankan Local Development Server**
   ```bash
   php artisan serve
   ```
   Aplikasi sekarang dapat diakses melalui browser di `http://127.0.0.1:8000`.

---

## 🔑 Akun Default (Testing)

Setelah menjalankan Seeder, Anda dapat login menggunakan akun berikut:

| Role | Username / Login | Password | Link Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin` | `password` | `/login` |
| **Petugas**| `petugas` | `password` | `/login` |
| **Siswa** | Menggunakan NISN Siswa | `password` (default) | `/siswa/login` |

---

## 🎨 UI/UX Highlights
- **Glassmorphism & Backdrop Blur:** Penggunaan efek kaca tembus pandang pada komponen UI.
- **Dynamic Scroll Fix:** Layout flexbox yang dikonfigurasi khusus (`min-height: 0`, `calc()`) untuk mencegah konten terpotong.
- **Sticky Backgrounds:** Gambar latar belakang yang tetap (fixed) saat konten di-scroll, memberikan kesan premium.
- **Micro-interactions:** Efek hover, animasi transisi saat pindah halaman, dan form validasi interaktif.

---
*Dibuat untuk keperluan sistem administrasi sekolah modern.*
