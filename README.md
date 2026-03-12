# Sistem Aplikasi PPDB (Penerimaan Peserta Didik Baru) SMK

## 1. Pendahuluan
Dokumen ini merupakan hasil analisis dan ringkasan pengujian (QA Analyst Report) terhadap sistem Penerimaan Peserta Didik Baru (PPDB) Sekolah Menengah Kejuruan (SMK) yang dibangun. Di dalam dokumen ini dipaparkan analisis menyeluruh mengenai Tech Stack yang digunakan, Alur Bisnis (Business Flow) dari pendaftaran hingga penerimaan, serta ringkasan fitur lengkap yang tersedia pada sistem, baik di sisi Siswa/Pendaftar maupun sisi Administrator.

---

## 2. Tech Stack yang Digunakan

Proyek web PPDB ini secara konsisten dibangun menggunakan teknologi modern yang sangat bergantung pada ekosistem **TALL Stack** (Tailwind, Alpine, Laravel, Livewire) plus integrasi komponen UI siap pakai.

### Backend (Server-Side)
- **Framework Utama:** Laravel v12.0
- **Bahasa Pemrograman:** PHP ^8.2
- **Database ORM:** Eloquent ORM (Mendukung MySQL / PostgreSQL / SQLite)
- **Sistem Templating Engine:** Blade

### Frontend (Client-Side)
- **Framework UI Reaktif:** Livewire v4.2 (SSR yang terintegrasi secara seamless dengan Laravel)
- **JavaScript Framework (Lightweight):** Alpine.js v3.15.8 (Menangani state management & UI interaction di level DOM)
- **CSS Framework:** Tailwind CSS v4.2.1
- **Komponen UI library:** DaisyUI v5.5.19 (Berbasis Tailwind, mempercepat pembuatan UI yang konsisten)
- **Bundler Asset:** Vite v7.0.7 (dikombinasikan dengan `laravel-vite-plugin`)

### Library & Package Tambahan Utama
- **Generasi Dokumen/Laporan (PDF):** `barryvdh/laravel-dompdf` (^3.1)
- **Ekspor/Impor Spreadsheet (Excel):** `phpoffice/phpspreadsheet` (^5.5)

---

## 3. Alur Bisnis (Business Flow)

Sistem PPDB ini dirancang menggunakan alur bertahap (*Wizard-based Registration*) untuk memudahkan calon siswa dalam mendaftar dan meminimalisir kesalahan input data.

### A. Alur Pendaftaran Siswa (Pendaftar)
Kondisi Pre-syarat: Calon siswa harus memilih **Periode Pendaftaran** yang berstatus Aktif/Buka.

1. **Registrasi Akun:** Calon siswa membuat akun pada sistem.
2. **Step 1 - Data Pribadi:** Melengkapi Nomor Induk Kependudukan (NIK), nama lengkap, tempat/tanggal lahir, jenis kelamin, agama, alamat domisili, dan kontak (Email/No Telp).
3. **Step 2 - Sekolah Asal:** Melengkapi detil sekolah sebelumnya seperti Nama Sekolah Asal, Alamat, Tahun Lulus, NISN (Nomor Induk Siswa Nasional), dan Rata-rata Nilai Rapor.
4. **Step 3 - Data Orang Tua:** Memasukkan identitas Ayah dan Ibu, meliputi NIK, Tempat/Tanggal Lahir, Pekerjaan, Estimasi Penghasilan, dan Kontak/Alamat.
5. **Step 4 - Pemilihan Jurusan:** Calon siswa diwajibkan memilih **Jurusan Utama**, dan diberikan opsi opsional untuk memilih **Jurusan Cadangan** (*Pilihan 2*).
6. **Step 5 - Unggah Dokumen:** Mengunggah file berkas digital dengan validasi format/ukuran. Dokumen yang dibutuhkan:
    - Ijazah / SKL
    - Kartu Keluarga (KK)
    - Akte Kelahiran
    - Pas Foto
    - Bukti Pembayaran (Pendaftaran)
    - Kartu Indonesia Pintar (KIP) — *Opsional*
7. **Finalisasi & Cetak Bukti Pendaftaran:** Setelah semua dokumen terunggah penuh, status pendaftaran menjadi `Menunggu Verifikasi`. Siswa dapat mengunduh dan mencetak form pendaftaran sebagai bukti fisik.

### B. Flow Status Penerimaan (State Machine Pendaftaran)
Sistem menggunakan siklus hidup status Pendaftaran berikut:
- `Draft` → Baru mulai mendaftar dan belum menuntaskan Step 1-5.
- `Menunggu Pembayaran` → Administrasi awal (tergantung setup pembayaran admin).
- `Menunggu Verifikasi` → Form disubmit dan dokumen selesai diunggah, menunggu pihak sekolah.
- `Terverifikasi` → Dokumen/Administrasi sudah divalidasi sah oleh pihak admin sekolah.
- `Diterima` / `Ditolak` / `Cadangan` → Merupakan keputusan akhir rekam jejak seleksi siswa.

### C. Alur Verifikasi Admin
1. Admin memonitor dashboard `Pendaftar`.
2. Admin mengecek kelengkapan data vs dokumen pendaftar.
3. Melalui modul **Verifikasi**, admin akan menyetujui (valid) atau menolak (invalid) dokumen-dokumen tadi.
4. Setelah valid, admin dapat mengubah status pendaftaran final (*Terima / Tolak / Cadangan*) bergantung dari perankingan dan kapasitas kuota jurusan.

---

## 4. Daftar Fitur Lengkap Sistem (System Features)

### A. Fitur Publik (Landing Page)
- **Halaman Muka (Homepage):** Informasi sekolah, jurusan yang tersedia.
- **Papan Pengumuman:** Menampilkan portal informasi secara publik untuk dibaca pengunjung non-login.

### B. Fitur Sisi Pendaftar (Calon Siswa)
- **Autentikasi:** Mendaftar, Login, dan Logout akun calon siswa.
- **Wizard Pendaftaran bertahap (Multi-step form):**
  - Form Data Diri (Data Pribadi)
  - Form Riwayat Sekolah (Sekolah Asal)
  - Form Identitas Wali (Data Orang Tua)
  - Dropdown Pemilihan Jurusan (Pilihan 1 & 2)
  - Upload Module (File Upload untuk berkas & dokumen digital)
- **Cetak Bukti Registrasi:** Export detil pendaftaran siswa final menjadi format yang siap diprint.
- **Dashboard Siswa:**
  - Status Realtime (tracking proses pendaftaran & seleksi).
  - Info Pengumuman spesifik dari Sekolah.
  - Halaman Profil pengguna.

### C. Fitur Sisi Administrator / Sekolah
- **Dashboard Admin Utama:** Menampilkan widget statistik pendaftaran (Total Kuota, Pendaftar Valid, Jurusan terfavorit, dll).
- **Manajemen Pendaftar:**
  - *Data Table* melihat list seluruh pendaftar, pencarian, & filter.
  - Aksi langsung pengubahan Status Kelulusan (Terima, Tolak, Kembalikan sebagai Cadangan).
- **Modul Verifikasi Dokumen:** Meninjau (Preview) dokumen Ijazah, KK, dll dan memberi status verifikasi kelayakan terhadap setiap berkas.
- **Manajemen Jurusan:** (CRUD) Menambahkan jurusan, menonaktifkan, edit informasi.
- **Manajemen Pengumuman (CMS Mini):** Membuat konten pengumuman/berita pendaftaran (Create, Edit, Hapus, Toggle Publish) bagi publik dan internal.
- **Manajemen Pengaturan & Preferensi PPDB:**
  - CRUD Periode Tahun Ajaran (Buka / Tutup pendaftaran).
  - Manajemen Penentuan Kuota Daya Tampung per jurusan.
- **Modul Laporan (Export Tools):**
  - Export Database Pendaftar Lengkap menjadi **Excel** (`.xlsx`).
  - Laporan Summary PDF.

---
&copy; 2026 WOKA. All rights reserved.
