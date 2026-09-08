# CarePlate - Nutrition & Health Management Platform

> **HOLOGY 9.0 - HoloDev (Software Development Competition)**  
> **Subtema:** Kesehatan (*Inovasi digital untuk meningkatkan kualitas layanan kesehatan yang preventif, inklusif, dan berpusat pada kebutuhan manusia*)

---

## 📌 Ringkasan Proyek

**CarePlate** adalah platform berbasis web yang dirancang untuk membantu masyarakat memantau dan mengelola kesehatan gizi secara mandiri maupun bersama keluarga. Aplikasi ini menyediakan solusi komprehensif mulai dari kalkulasi indeks massa tubuh (BMI) dan kebutuhan kalori harian (BMR & TDEE), pencatatan asupan nutrisi harian (kalori, karbohidrat, protein, lemak), katalog nutrisi makanan terverifikasi, grup nutrisi keluarga dengan kode unik, edukasi gizi melalui artikel kesehatan, hingga direktori konsultasi ahli gizi.

---

## 🌐 Tautan Deployment & Demo

* **URL Deployment (Live):** [https://careplate.tunggulmajid.my.id/](https://careplate.tunggulmajid.my.id/)
* **Akses Lokal:** `http://127.0.0.1:8000`

---

## 💻 1. Spesifikasi Lingkungan Pengujian (*Environment*)

Untuk menjalankan dan menguji aplikasi ini, pastikan sistem Anda telah memenuhi spesifikasi berikut:

### Kebutuhan Perangkat Lunak:
* **Sistem Operasi:** Windows 10/11, macOS, atau Linux (Ubuntu 20.04/22.04 LTS direkomendasikan)
* **PHP:** Versi **8.2.0** atau lebih tinggi
  * Ekstensi PHP yang dibutuhkan: `OpenSSL`, `PDO`, `PDO_MySQL`, `Mbstring`, `Tokenizer`, `XML`, `Ctype`, `JSON`, `BCMath`, `cURL`, `Fileinfo`
* **Web Server:** Apache / Nginx (atau bawaan PHP Built-in Server `php artisan serve`)
* **Basis Data:** MySQL versi **8.0+** atau MariaDB versi **10.4+**
* **Composer:** Versi **2.5.0** atau lebih tinggi
* **Node.js & NPM:** Node.js versi **18.x** atau **20.x LTS**, NPM versi **9.x+**
* **Web Browser:** Google Chrome, Mozilla Firefox, atau Microsoft Edge versi terbaru

---

## ⚙️ 2. Panduan Instalasi (*Installation Guide*)

Ikuti langkah-langkah berikut secara berurutan untuk memasang aplikasi dari source code:

### Langkah 1: Ekstrak / Clone Source Code
Jika menggunakan arsip `.zip` atau `.rar`, ekstrak berkas ke direktori kerja Anda, lalu buka terminal di folder tersebut:
```bash
cd Careplate-Deploy
```

### Langkah 2: Instalasi Dependensi Backend (Composer)
Jalankan perintah berikut untuk mengunduh seluruh library PHP yang diperlukan:
```bash
composer install
```

### Langkah 3: Konfigurasi Berkas Environment (`.env`)
Salin berkas `.env.example` menjadi `.env` (atau sesuaikan berkas `.env` yang sudah tersedia):
```bash
# Untuk Linux / macOS
cp .env.example .env

# Untuk Windows PowerShell
copy .env.example .env
```

Buka berkas `.env` dan sesuaikan pengaturan koneksi basis data MySQL Anda:
```env
APP_NAME=CarePlate
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=password_database_anda
```

### Langkah 4: Generate Application Key
Buat kunci enkripsi aplikasi Laravel:
```bash
php artisan key:generate
```

### Langkah 5: Migrasi Database & Seeding Data
Buat seluruh tabel database beserta data awal (roles, user demo, katalog makanan, artikel, dan ahli gizi):
```bash
php artisan migrate:fresh --seed
```

### Langkah 6: Tautkan Storage Simbolik
Pastikan folder storage publik dapat diakses untuk upload gambar dan aset:
```bash
php artisan storage:link
```

### Langkah 7: Instalasi & Kompilasi Aset Frontend (NPM)
Instal dependensi JavaScript / Tailwind CSS dan lakukan build aset:
```bash
npm install
npm run build
```

---

## 🚀 3. Cara Menjalankan Aplikasi (*How to Run*)

### Opsi A: Mode Standar (Development)
Jalankan server aplikasi lokal Laravel:
```bash
php artisan serve
```
Aplikasi dapat langsung diakses melalui browser di: **`http://127.0.0.1:8000`**

*(Opsional)* Jika Anda ingin melakukan perubahan pada tampilan/style CSS secara langsung:
```bash
npm run dev
```

### Opsi B: Menggunakan Script Otomatis (Concurrently)
Aplikasi ini juga menyediakan perintah siap pakai yang menjalankan server dan build asset secara bersamaan:
```bash
composer run dev
```

---

## 🔑 4. Akun Demo Pengujian (*Demo Accounts*)

Aplikasi ini menggunakan Role-Based Access Control (RBAC) dengan 2 tingkatan hak akses:

| Peran (*Role*) | Email Akun | Kata Sandi (*Password*) | Deskripsi Hak Akses |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@gmail.com` | `password` | Mengelola data pengguna, katalog makanan, kategori, verifikasi pengajuan makanan, artikel, dan data ahli gizi. |
| **Pengguna (User)** | `pengguna@gmail.com` | `password` | Menghitung kalkulator gizi & BMI, melacak kalori makanan, membuat/bergabung grup keluarga, dan mengajukan data makanan baru. |

> **Catatan:** Pengguna baru juga dapat melakukan pendaftaran mandiri melalui halaman **Register** (`/register`) atau menggunakan fitur Single Sign-On (SSO) **Google Login** (`/auth/google`).

---

## 📋 5. Fitur Utama yang Dapat Diuji

1. **Dashboard Pengguna & Pelacakan Kalori (`/trackingkalori`)**:
   * Input konsumsi makanan per kategori waktu (sarapan, makan siang, makan malam, camilan).
   * Visualisasi target vs asupan kalori menggunakan Donut Chart & Bar Chart progres mingguan/bulanan.
2. **Kalkulator BMI & Kebutuhan Kalori (`/kalkulator`)**:
   * Perhitungan otomatis BMI, klasifikasi berat badan, BMR, dan kebutuhan kalori harian (TDEE).
   * Riwayat kalkulasi kesehatan tersimpan otomatis.
3. **Pencarian Kalori & Database Makanan (`/makanan/carikalori`)**:
   * Pencarian daftar makanan lengkap dengan rincian kalori, karbohidrat, protein, dan lemak.
4. **Pengajuan Makanan Baru (`/makanan/pengajuan`)**:
   * Form pengajuan makanan baru oleh user untuk diverifikasi oleh admin.
5. **Grup Gizi Keluarga (`/keluarga`)**:
   * Buat keluarga baru dengan kode undangan unik (*family code*).
   * Gabung ke keluarga anggota lain menggunakan kode keluarga.
   * Pantau progres dan status nutrisi antaranggota keluarga.
6. **Panel Admin (`/admin/dashboard`)**:
   * Manajemen data user, makanan, artikel edukasi, data ahli gizi, dan persetujuan pengajuan makanan.

---

## 👥 Tim Pengembang
* **Cabang Lomba:** HoloDev - Software Development Competition
* **Kompetisi:** HOLOGY 9.0 Universitas Brawijaya
