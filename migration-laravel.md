# Struktur File & Database PPDB SMK

## Penjelasan Lengkap Sistem PPDB SMK Swasta NU II Medan

---

## 📁 Struktur File Proyek Laravel

```
ppdb-smk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php          # Halaman login siswa & admin
│   │   │   │   ├── RegisterController.php        # Halaman registrasi akun siswa
│   │   │   │   └── LogoutController.php          # Proses logout
│   │   │   ├── Siswa/
│   │   │   │   ├── DashboardController.php       # Dashboard siswa
│   │   │   │   ├── PendaftaranController.php     # Multi-step form pendaftaran
│   │   │   │   ├── DokumenController.php         # Upload & lihat dokumen
│   │   │   │   ├── PembayaranController.php      # Upload bukti pembayaran
│   │   │   │   └── PengumumanController.php      # Lihat pengumuman hasil
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php       # Dashboard admin (statistik)
│   │   │   │   ├── PendaftarController.php       # Daftar & detail pendaftar
│   │   │   │   ├── VerifikasiController.php      # Verifikasi berkas & pembayaran
│   │   │   │   ├── PengumumanController.php      # Kelola pengumuman
│   │   │   │   ├── JurusanController.php         # Kelola data jurusan
│   │   │   │   └── LaporanController.php         # Export & laporan data
│   │   │   └── LandingPageController.php         # Halaman utama publik
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php               # Cek akses admin
│   │   │   └── SiswaMiddleware.php               # Cek akses siswa
│   │   └── Livewire/
│   │       ├── Siswa/
│   │       │   ├── FormPendaftaran.php            # Multi-step form (Livewire)
│   │       │   ├── UploadDokumen.php              # Upload dokumen real-time
│   │       │   └── UploadBuktiPembayaran.php      # Upload bukti bayar
│   │       └── Admin/
│   │           ├── TabelPendaftar.php             # Tabel pendaftar dengan filter
│   │           ├── DetailPendaftar.php            # Detail & verifikasi
│   │           ├── StatistikDashboard.php         # Statistik real-time
│   │           └── CariPendaftar.php              # Pencarian pendaftar
│   ├── Models/
│   │   ├── User.php                              # Model pengguna
│   │   ├── Jurusan.php                           # Model jurusan
│   │   ├── PengaturanPpdb.php                    # Model pengaturan PPDB
│   │   ├── Pendaftaran.php                       # Model pendaftaran
│   │   ├── Siswa.php                             # Model data pribadi siswa
│   │   ├── SekolahAsal.php                       # Model sekolah asal
│   │   ├── OrangTua.php                          # Model orang tua/wali
│   │   ├── Dokumen.php                           # Model dokumen
│   │   ├── Pembayaran.php                        # Model pembayaran
│   │   ├── VerifikasiLog.php                     # Model log verifikasi
│   │   └── Pengumuman.php                        # Model pengumuman
│   └── Enums/
│       ├── StatusPendaftaran.php                  # Enum status pendaftaran
│       ├── JenisDokumen.php                       # Enum jenis dokumen
│       └── JenisOrangTua.php                      # Enum jenis ortu
│
├── database/
│   ├── migrations/
│   │   ├── 0001_create_users_table.php
│   │   ├── 0002_create_jurusan_table.php
│   │   ├── 0003_create_pengaturan_ppdb_table.php
│   │   ├── 0004_create_pendaftaran_table.php
│   │   ├── 0005_create_siswa_table.php
│   │   ├── 0006_create_sekolah_asal_table.php
│   │   ├── 0007_create_orang_tua_table.php
│   │   ├── 0008_create_dokumen_table.php
│   │   ├── 0009_create_pembayaran_table.php
│   │   ├── 0010_create_verifikasi_log_table.php
│   │   └── 0011_create_pengumuman_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminSeeder.php                       # Data admin default
│       ├── JurusanSeeder.php                     # Data jurusan (TKJ, AKL, dll)
│       └── PengaturanPpdbSeeder.php              # Periode PPDB 2026/2027
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                     # Layout utama (navbar + footer)
│       │   ├── admin.blade.php                   # Layout admin (sidebar + header)
│       │   └── guest.blade.php                   # Layout tanpa login
│       ├── components/
│       │   ├── navbar.blade.php                  # Komponen navbar
│       │   ├── sidebar.blade.php                 # Komponen sidebar admin
│       │   ├── footer.blade.php                  # Komponen footer
│       │   ├── alert.blade.php                   # Komponen notifikasi/alert
│       │   ├── badge-status.blade.php            # Badge status (diterima/ditolak/dll)
│       │   ├── card.blade.php                    # Komponen card
│       │   ├── modal.blade.php                   # Komponen modal
│       │   └── progress-step.blade.php           # Step indicator multi-step form
│       ├── auth/
│       │   ├── login.blade.php                   # Halaman login
│       │   └── register.blade.php                # Halaman registrasi
│       ├── landing.blade.php                     # Landing page PPDB
│       ├── siswa/
│       │   ├── dashboard.blade.php               # Dashboard siswa
│       │   ├── pendaftaran.blade.php             # Form multi-step
│       │   ├── dokumen.blade.php                 # Upload dokumen
│       │   ├── pembayaran.blade.php              # Upload bukti bayar
│       │   ├── profil.blade.php                  # Profil siswa
│       │   └── pengumuman.blade.php              # Lihat pengumuman
│       ├── admin/
│       │   ├── dashboard.blade.php               # Dashboard admin
│       │   ├── pendaftar/
│       │   │   ├── index.blade.php               # Daftar pendaftar
│       │   │   └── detail.blade.php              # Detail pendaftar
│       │   ├── verifikasi.blade.php              # Halaman verifikasi
│       │   ├── pengumuman.blade.php              # Kelola pengumuman
│       │   └── laporan.blade.php                 # Laporan & export
│       └── pengumuman/
│           └── index.blade.php                   # Halaman pengumuman publik
│
├── routes/
│   └── web.php                                   # Semua route aplikasi
│
├── public/
│   ├── css/
│   ├── js/
│   └── uploads/                                  # Folder upload dokumen & bukti bayar
│       ├── dokumen/
│       ├── pembayaran/
│       └── foto/
│
└── storage/
    └── app/
        └── ppdb/                                 # Storage file privat
            ├── dokumen/
            ├── pembayaran/
            └── foto/
```

---

## 🗄️ Skema Database (ERD)

### Diagram Relasi Antar Tabel

```mermaid
erDiagram
    users ||--o{ pendaftaran : "mendaftar"
    users ||--o{ verifikasi_log : "memverifikasi"
    users ||--o{ pengumuman : "membuat"
    users ||--o{ pembayaran : "memverifikasi"

    pengaturan_ppdb ||--o{ pendaftaran : "periode"
    pengaturan_ppdb ||--o{ pengumuman : "periode"

    jurusan ||--o{ pendaftaran : "pilihan_1"
    jurusan ||--o{ pendaftaran : "pilihan_2"

    pendaftaran ||--|| siswa : "data_pribadi"
    pendaftaran ||--|| sekolah_asal : "asal_sekolah"
    pendaftaran ||--o{ orang_tua : "data_ortu"
    pendaftaran ||--o{ dokumen : "berkas"
    pendaftaran ||--o{ pembayaran : "bayar"
    pendaftaran ||--o{ verifikasi_log : "riwayat"

    users {
        bigint id PK
        varchar nama_lengkap
        varchar email UK
        varchar password
        enum role "admin/siswa"
        timestamp email_verified_at
    }

    jurusan {
        bigint id PK
        varchar kode_jurusan UK "TKJ/AKL/BDP/MM"
        varchar nama_jurusan
        text deskripsi
        int kuota
        boolean is_active
    }

    pengaturan_ppdb {
        bigint id PK
        varchar tahun_ajaran "2026/2027"
        date tanggal_buka
        date tanggal_tutup
        date tanggal_pengumuman
        date tanggal_daftar_ulang_mulai
        date tanggal_daftar_ulang_selesai
        decimal biaya_pendaftaran
        boolean is_active
    }

    pendaftaran {
        bigint id PK
        bigint user_id FK
        bigint pengaturan_ppdb_id FK
        bigint jurusan_id FK
        bigint jurusan_id_2 FK "nullable"
        varchar nomor_pendaftaran UK "PPDB-2026-0001"
        timestamp tanggal_daftar
        enum status "draft/menunggu/terverifikasi/diterima/ditolak/cadangan"
        text catatan_admin
        tinyint step_terakhir "1-5"
    }

    siswa {
        bigint id PK
        bigint pendaftaran_id FK-UK
        varchar nik "16 digit"
        varchar nama_lengkap
        varchar tempat_lahir
        date tanggal_lahir
        enum jenis_kelamin
        enum agama
        text alamat_lengkap
        varchar no_telepon
    }

    sekolah_asal {
        bigint id PK
        bigint pendaftaran_id FK-UK
        varchar nisn
        varchar nama_sekolah
        text alamat_sekolah
        year tahun_lulus
        decimal nilai_rata_rata
    }

    orang_tua {
        bigint id PK
        bigint pendaftaran_id FK
        enum jenis "ayah/ibu/wali"
        varchar nama_lengkap
        varchar nik
        varchar pekerjaan
        enum penghasilan
        varchar no_telepon
    }

    dokumen {
        bigint id PK
        bigint pendaftaran_id FK
        enum jenis_dokumen "ijazah/kk/akte/foto/dll"
        varchar nama_file
        varchar file_path
        int ukuran_file
        enum status_verifikasi "menunggu/valid/tidak_valid"
        varchar catatan
    }

    pembayaran {
        bigint id PK
        bigint pendaftaran_id FK
        decimal jumlah
        enum metode_pembayaran
        varchar bukti_pembayaran_path
        date tanggal_bayar
        enum status "menunggu/terverifikasi/ditolak"
        bigint verified_by FK
    }

    verifikasi_log {
        bigint id PK
        bigint pendaftaran_id FK
        bigint admin_id FK
        varchar status_sebelum
        varchar status_sesudah
        text catatan
        timestamp created_at
    }

    pengumuman {
        bigint id PK
        bigint pengaturan_ppdb_id FK
        varchar judul
        text isi
        boolean is_published
        bigint created_by FK
    }
```

---

## 📋 Penjelasan Setiap Tabel

### 1. `users` — Tabel Pengguna
Menyimpan data akun login untuk **siswa** dan **admin**.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT (PK) | ID unik pengguna |
| `nama_lengkap` | VARCHAR(255) | Nama lengkap pengguna |
| `email` | VARCHAR(255) | Email untuk login (unik) |
| `password` | VARCHAR(255) | Password yang di-hash (bcrypt) |
| `role` | ENUM | Peran: `admin` atau `siswa` |
| `email_verified_at` | TIMESTAMP | Waktu verifikasi email |

---

### 2. `jurusan` — Tabel Master Jurusan
Menyimpan daftar **program keahlian** yang tersedia.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `kode_jurusan` | VARCHAR(10) | Kode singkat: TKJ, AKL, BDP, MM |
| `nama_jurusan` | VARCHAR(255) | Nama lengkap jurusan |
| `kuota` | INT | Kuota maksimal penerimaan |
| `is_active` | BOOLEAN | Apakah jurusan masih dibuka |

---

### 3. `pengaturan_ppdb` — Tabel Konfigurasi PPDB
Menyimpan **jadwal dan pengaturan** setiap periode PPDB.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `tahun_ajaran` | VARCHAR(20) | Contoh: "2026/2027" |
| `tanggal_buka` | DATE | Tanggal pembukaan pendaftaran |
| `tanggal_tutup` | DATE | Tanggal penutupan pendaftaran |
| `tanggal_pengumuman` | DATE | Tanggal pengumuman hasil seleksi |
| `biaya_pendaftaran` | DECIMAL | Biaya pendaftaran (0 = gratis) |

---

### 4. `pendaftaran` — Tabel Pendaftaran (Tabel Utama)
Menyimpan **data inti** setiap pendaftaran PPDB. Tabel ini menjadi **pusat relasi** ke tabel lainnya.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `user_id` | BIGINT (FK) | Relasi ke `users` — siapa yang mendaftar |
| `pengaturan_ppdb_id` | BIGINT (FK) | Relasi ke periode PPDB aktif |
| `jurusan_id` | BIGINT (FK) | Pilihan jurusan pertama |
| `jurusan_id_2` | BIGINT (FK) | Pilihan jurusan kedua (opsional) |
| `nomor_pendaftaran` | VARCHAR(30) | Nomor unik: PPDB-2026-0001 |
| `status` | ENUM | Status pendaftaran (lihat alur di bawah) |
| `step_terakhir` | TINYINT | Step form terakhir yang diisi (1-5) |
| `catatan_admin` | TEXT | Catatan dari admin |

**Status pendaftaran yang tersedia:**

| Status | Keterangan |
|---|---|
| `draft` | Siswa belum selesai mengisi semua form |
| `menunggu_pembayaran` | Form lengkap, menunggu upload bukti bayar |
| `menunggu_verifikasi` | Bukti bayar sudah diupload, menunggu admin |
| `terverifikasi` | Pembayaran & berkas sudah diverifikasi admin |
| `diterima` | Siswa diterima di jurusan |
| `ditolak` | Pendaftaran ditolak |
| `cadangan` | Masuk daftar cadangan |

---

### 5. `siswa` — Tabel Data Pribadi (Step 1 Form)
Menyimpan **data pribadi** calon siswa. Relasi **satu-ke-satu** dengan `pendaftaran`.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `nik` | VARCHAR(16) | NIK 16 digit |
| `nama_lengkap` | VARCHAR(255) | Nama sesuai akta/ijazah |
| `tempat_lahir` | VARCHAR(100) | Contoh: "Medan" |
| `tanggal_lahir` | DATE | Tanggal lahir |
| `jenis_kelamin` | ENUM | Laki-laki / Perempuan |
| `agama` | ENUM | Islam/Kristen/Katolik/Hindu/Buddha/Konghucu |
| `alamat_lengkap` | TEXT | Jalan, RT/RW, Kelurahan, Kecamatan |

---

### 6. `sekolah_asal` — Tabel Sekolah Asal (Step 2 Form)
Menyimpan **data sekolah** asal siswa. Relasi **satu-ke-satu** dengan `pendaftaran`.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `nisn` | VARCHAR(20) | NISN siswa |
| `nama_sekolah` | VARCHAR(255) | Contoh: "SMP Negeri 1 Medan" |
| `tahun_lulus` | YEAR | Tahun kelulusan |
| `nilai_rata_rata` | DECIMAL(5,2) | Nilai rata-rata rapor |

---

### 7. `orang_tua` — Tabel Data Orang Tua (Step 3 Form)
Menyimpan **data ayah, ibu, dan wali** siswa. Satu pendaftaran bisa memiliki **beberapa record** (ayah + ibu + wali).

| Kolom | Tipe | Keterangan |
|---|---|---|
| `jenis` | ENUM | `ayah`, `ibu`, atau `wali` |
| `nama_lengkap` | VARCHAR(255) | Nama lengkap orang tua |
| `pekerjaan` | VARCHAR(255) | Pekerjaan orang tua |
| `penghasilan` | ENUM | Range: kurang_1jt s/d lebih_10jt |
| `no_telepon` | VARCHAR(20) | Nomor HP orang tua |

---

### 8. `dokumen` — Tabel Dokumen Pendukung (Step 5 Form)
Menyimpan **file yang diupload** siswa. Setiap pendaftaran bisa memiliki **banyak dokumen**.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `jenis_dokumen` | ENUM | ijazah, kartu_keluarga, akte, pas_foto, kip, dll |
| `file_path` | VARCHAR(500) | Lokasi file di server |
| `ukuran_file` | INT | Ukuran file (bytes) |
| `status_verifikasi` | ENUM | `menunggu` / `valid` / `tidak_valid` |
| `catatan` | VARCHAR(500) | Catatan admin tentang dokumen |

---

### 9. `pembayaran` — Tabel Bukti Pembayaran
Menyimpan **data pembayaran** dan bukti transfer.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `jumlah` | DECIMAL(12,2) | Nominal pembayaran |
| `metode_pembayaran` | ENUM | transfer_bank / tunai / e_wallet |
| `bukti_pembayaran_path` | VARCHAR(500) | File bukti bayar |
| `status` | ENUM | `menunggu` / `terverifikasi` / `ditolak` |
| `verified_by` | BIGINT (FK) | Admin yang memverifikasi |

---

### 10. `verifikasi_log` — Tabel Log Verifikasi
Mencatat **setiap tindakan** yang dilakukan admin (audit trail).

| Kolom | Tipe | Keterangan |
|---|---|---|
| `admin_id` | BIGINT (FK) | Admin yang melakukan aksi |
| `status_sebelum` | VARCHAR(50) | Status sebelum diubah |
| `status_sesudah` | VARCHAR(50) | Status setelah diubah |
| `catatan` | TEXT | Alasan perubahan |

---

### 11. `pengumuman` — Tabel Pengumuman
Menyimpan **pengumuman hasil seleksi** yang dipublikasikan admin.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `judul` | VARCHAR(255) | Judul pengumuman |
| `isi` | TEXT | Isi pengumuman |
| `is_published` | BOOLEAN | Sudah dipublikasikan atau belum |
| `created_by` | BIGINT (FK) | Admin yang membuat |

---

## 🔄 Alur Data Sistem (Flow)

### Alur Pendaftar (Siswa)

```
Registrasi Akun (users)
    │
    ▼
Isi Form Step 1-5 (pendaftaran → siswa → sekolah_asal → orang_tua → jurusan → dokumen)
    │  status: "draft" → step_terakhir bertambah
    ▼
Form Lengkap
    │  status: "menunggu_pembayaran"
    ▼
Upload Bukti Pembayaran (pembayaran)
    │  status: "menunggu_verifikasi"
    ▼
Menunggu Verifikasi Admin
    │
    ▼
Terverifikasi → Diterima / Ditolak / Cadangan
    │
    ▼
Lihat Hasil di Halaman Pengumuman
```

### Alur Admin

```
Login Admin (users, role='admin')
    │
    ▼
Lihat Dashboard (statistik dari pendaftaran)
    │
    ▼
Lihat Daftar Pendaftar (pendaftaran + siswa + dokumen)
    │
    ▼
Klik Detail Pendaftar (semua data + dokumen + pembayaran)
    │
    ▼
Verifikasi Dokumen (dokumen.status_verifikasi)
    │
    ▼
Verifikasi Pembayaran (pembayaran.status)
    │
    ▼
Update Status Pendaftaran (pendaftaran.status + verifikasi_log)
    │  Terima / Tolak / Cadangan + Catatan
    ▼
Selesai (log tercatat di verifikasi_log)
```

---

## 🔗 Relasi Antar Model (Laravel Eloquent)

```php
// User.php
class User extends Authenticatable {
    public function pendaftaran() { return $this->hasMany(Pendaftaran::class); }
}

// Pendaftaran.php (PUSAT RELASI)
class Pendaftaran extends Model {
    public function user()          { return $this->belongsTo(User::class); }
    public function siswa()         { return $this->hasOne(Siswa::class); }
    public function sekolahAsal()   { return $this->hasOne(SekolahAsal::class); }
    public function orangTua()      { return $this->hasMany(OrangTua::class); }
    public function jurusan()       { return $this->belongsTo(Jurusan::class); }
    public function jurusanKedua()  { return $this->belongsTo(Jurusan::class, 'jurusan_id_2'); }
    public function dokumen()       { return $this->hasMany(Dokumen::class); }
    public function pembayaran()    { return $this->hasMany(Pembayaran::class); }
    public function verifikasiLog() { return $this->hasMany(VerifikasiLog::class); }
    public function pengaturanPpdb(){ return $this->belongsTo(PengaturanPpdb::class); }
}

// Jurusan.php
class Jurusan extends Model {
    public function pendaftaran() { return $this->hasMany(Pendaftaran::class); }
}
```

---

## ⚙️ Perintah Artisan Laravel

```bash
# Buat semua migration
php artisan make:migration create_users_table
php artisan make:migration create_jurusan_table
php artisan make:migration create_pengaturan_ppdb_table
php artisan make:migration create_pendaftaran_table
php artisan make:migration create_siswa_table
php artisan make:migration create_sekolah_asal_table
php artisan make:migration create_orang_tua_table
php artisan make:migration create_dokumen_table
php artisan make:migration create_pembayaran_table
php artisan make:migration create_verifikasi_log_table
php artisan make:migration create_pengumuman_table

# Buat semua model
php artisan make:model Jurusan
php artisan make:model PengaturanPpdb
php artisan make:model Pendaftaran
php artisan make:model Siswa
php artisan make:model SekolahAsal
php artisan make:model OrangTua
php artisan make:model Dokumen
php artisan make:model Pembayaran
php artisan make:model VerifikasiLog
php artisan make:model Pengumuman

# Jalankan migration & seeder
php artisan migrate
php artisan db:seed
```
