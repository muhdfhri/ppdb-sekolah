-- ============================================================
-- SKEMA DATABASE PPDB SMK SWASTA NAHDATUL ULAMA II MEDAN
-- Sistem Penerimaan Peserta Didik Baru (PPDB)
-- Database: MySQL / MariaDB
-- ============================================================

-- Hapus database jika sudah ada (opsional, hati-hati di production)
-- DROP DATABASE IF EXISTS ppdb_smk;
-- CREATE DATABASE ppdb_smk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE ppdb_smk;

-- ============================================================
-- 1. TABEL USERS (Pengguna Sistem)
-- Menyimpan data akun login untuk siswa dan admin
-- ============================================================
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL COMMENT 'Nama lengkap pengguna',
    email VARCHAR(255) NOT NULL UNIQUE COMMENT 'Email untuk login',
    password VARCHAR(255) NOT NULL COMMENT 'Password yang di-hash',
    role ENUM('admin', 'siswa') NOT NULL DEFAULT 'siswa' COMMENT 'Peran: admin atau siswa',
    email_verified_at TIMESTAMP NULL COMMENT 'Waktu verifikasi email',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Tabel akun pengguna (siswa & admin)';


-- ============================================================
-- 2. TABEL JURUSAN (Master Data Jurusan/Program Keahlian)
-- Menyimpan daftar jurusan yang tersedia di SMK
-- ============================================================
CREATE TABLE jurusan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_jurusan VARCHAR(10) NOT NULL UNIQUE COMMENT 'Kode singkat jurusan, misal: TKJ',
    nama_jurusan VARCHAR(255) NOT NULL COMMENT 'Nama lengkap jurusan',
    deskripsi TEXT NULL COMMENT 'Deskripsi jurusan',
    kuota INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Kuota maksimal siswa per jurusan',
    is_active BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Status aktif jurusan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Master data jurusan/program keahlian';

-- Data awal jurusan
INSERT INTO jurusan (kode_jurusan, nama_jurusan, deskripsi, kuota) VALUES
('TKJ', 'Teknik Komputer & Jaringan', 'Mempelajari instalasi, konfigurasi, dan troubleshooting jaringan komputer', 120),
('AKL', 'Akuntansi & Keuangan Lembaga', 'Mempelajari prinsip akuntansi, keuangan, dan perpajakan', 80),
('BDP', 'Bisnis Daring & Pemasaran', 'Mempelajari strategi bisnis online dan pemasaran digital', 80),
('MM', 'Multimedia', 'Mempelajari desain grafis, animasi, dan produksi konten digital', 80);


-- ============================================================
-- 3. TABEL PENGATURAN PPDB (Konfigurasi Periode PPDB)
-- Menyimpan pengaturan periode pendaftaran
-- ============================================================
CREATE TABLE pengaturan_ppdb (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tahun_ajaran VARCHAR(20) NOT NULL COMMENT 'Tahun ajaran, misal: 2026/2027',
    tanggal_buka DATE NOT NULL COMMENT 'Tanggal pembukaan pendaftaran',
    tanggal_tutup DATE NOT NULL COMMENT 'Tanggal penutupan pendaftaran',
    tanggal_pengumuman DATE NULL COMMENT 'Tanggal pengumuman hasil',
    tanggal_daftar_ulang_mulai DATE NULL COMMENT 'Tanggal mulai daftar ulang',
    tanggal_daftar_ulang_selesai DATE NULL COMMENT 'Tanggal selesai daftar ulang',
    biaya_pendaftaran DECIMAL(12,2) DEFAULT 0 COMMENT 'Biaya pendaftaran (0 jika gratis)',
    is_active BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Status periode aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Konfigurasi periode PPDB';


-- ============================================================
-- 4. TABEL PENDAFTARAN (Data Pendaftaran Siswa)
-- Menyimpan data utama setiap pendaftaran PPDB
-- ============================================================
CREATE TABLE pendaftaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL COMMENT 'Relasi ke tabel users',
    pengaturan_ppdb_id BIGINT UNSIGNED NOT NULL COMMENT 'Relasi ke periode PPDB',
    jurusan_id BIGINT UNSIGNED NOT NULL COMMENT 'Jurusan pilihan pertama',
    jurusan_id_2 BIGINT UNSIGNED NULL COMMENT 'Jurusan pilihan kedua (opsional)',
    nomor_pendaftaran VARCHAR(30) NOT NULL UNIQUE COMMENT 'Nomor unik pendaftaran, misal: PPDB-2026-0001',
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Waktu pendaftaran',
    status ENUM(
        'draft',              -- Belum lengkap mengisi form
        'menunggu_pembayaran', -- Form lengkap, belum bayar
        'menunggu_verifikasi', -- Sudah bayar, menunggu verifikasi admin
        'terverifikasi',       -- Pembayaran & berkas diverifikasi
        'diterima',            -- Diterima di jurusan
        'ditolak',             -- Ditolak
        'cadangan'             -- Masuk daftar cadangan
    ) NOT NULL DEFAULT 'draft' COMMENT 'Status pendaftaran',
    catatan_admin TEXT NULL COMMENT 'Catatan dari admin saat verifikasi',
    step_terakhir TINYINT UNSIGNED DEFAULT 1 COMMENT 'Step form terakhir yang diisi (1-5)',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (pengaturan_ppdb_id) REFERENCES pengaturan_ppdb(id),
    FOREIGN KEY (jurusan_id) REFERENCES jurusan(id),
    FOREIGN KEY (jurusan_id_2) REFERENCES jurusan(id)
) ENGINE=InnoDB COMMENT='Data pendaftaran siswa PPDB';


-- ============================================================
-- 5. TABEL SISWA (Data Pribadi Siswa)
-- Menyimpan data pribadi calon siswa (Step 1 Form)
-- ============================================================
CREATE TABLE siswa (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftaran_id BIGINT UNSIGNED NOT NULL UNIQUE COMMENT 'Relasi ke tabel pendaftaran (1:1)',
    nik VARCHAR(16) NOT NULL COMMENT 'Nomor Induk Kependudukan (16 digit)',
    nama_lengkap VARCHAR(255) NOT NULL COMMENT 'Nama lengkap sesuai akta/ijazah',
    tempat_lahir VARCHAR(100) NOT NULL COMMENT 'Tempat lahir',
    tanggal_lahir DATE NOT NULL COMMENT 'Tanggal lahir',
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL COMMENT 'Jenis kelamin',
    agama ENUM('Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu') NOT NULL DEFAULT 'Islam',
    alamat_lengkap TEXT NOT NULL COMMENT 'Alamat lengkap (jalan, RT/RW, kelurahan, kecamatan)',
    no_telepon VARCHAR(20) NULL COMMENT 'Nomor HP siswa',
    email VARCHAR(255) NULL COMMENT 'Email siswa',
    foto_path VARCHAR(500) NULL COMMENT 'Path file foto pas siswa',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (pendaftaran_id) REFERENCES pendaftaran(id) ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Data pribadi calon siswa (Step 1)';


-- ============================================================
-- 6. TABEL SEKOLAH ASAL (Data Sekolah Asal Siswa)
-- Menyimpan informasi sekolah asal siswa (Step 2 Form)
-- ============================================================
CREATE TABLE sekolah_asal (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftaran_id BIGINT UNSIGNED NOT NULL UNIQUE COMMENT 'Relasi ke tabel pendaftaran (1:1)',
    nisn VARCHAR(20) NULL COMMENT 'Nomor Induk Siswa Nasional',
    nama_sekolah VARCHAR(255) NOT NULL COMMENT 'Nama sekolah asal (SMP/MTs)',
    alamat_sekolah TEXT NULL COMMENT 'Alamat sekolah asal',
    tahun_lulus YEAR NOT NULL COMMENT 'Tahun kelulusan',
    nilai_rata_rata DECIMAL(5,2) NULL COMMENT 'Nilai rata-rata rapor/ijazah',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (pendaftaran_id) REFERENCES pendaftaran(id) ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Data sekolah asal siswa (Step 2)';


-- ============================================================
-- 7. TABEL ORANG TUA (Data Orang Tua / Wali)
-- Menyimpan data orang tua dan wali siswa (Step 3 Form)
-- ============================================================
CREATE TABLE orang_tua (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftaran_id BIGINT UNSIGNED NOT NULL COMMENT 'Relasi ke tabel pendaftaran',
    jenis ENUM('ayah', 'ibu', 'wali') NOT NULL COMMENT 'Jenis: ayah, ibu, atau wali',
    nama_lengkap VARCHAR(255) NOT NULL COMMENT 'Nama lengkap orang tua/wali',
    nik VARCHAR(16) NULL COMMENT 'NIK orang tua/wali',
    tempat_lahir VARCHAR(100) NULL,
    tanggal_lahir DATE NULL,
    pekerjaan VARCHAR(255) NULL COMMENT 'Pekerjaan orang tua/wali',
    penghasilan ENUM(
        'kurang_1jt',
        '1jt_3jt',
        '3jt_5jt',
        '5jt_10jt',
        'lebih_10jt'
    ) NULL COMMENT 'Range penghasilan per bulan',
    no_telepon VARCHAR(20) NULL COMMENT 'Nomor HP orang tua/wali',
    alamat TEXT NULL COMMENT 'Alamat orang tua/wali',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (pendaftaran_id) REFERENCES pendaftaran(id) ON DELETE CASCADE,
    UNIQUE KEY unique_ortu (pendaftaran_id, jenis)
) ENGINE=InnoDB COMMENT='Data orang tua/wali siswa (Step 3)';


-- ============================================================
-- 8. TABEL DOKUMEN (Upload Dokumen Pendukung)
-- Menyimpan file dokumen yang diupload siswa (Step 5 Form)
-- ============================================================
CREATE TABLE dokumen (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftaran_id BIGINT UNSIGNED NOT NULL COMMENT 'Relasi ke tabel pendaftaran',
    jenis_dokumen ENUM(
        'ijazah',          -- Ijazah / SKL
        'kartu_keluarga',  -- Kartu Keluarga
        'akte_kelahiran',  -- Akte Kelahiran
        'pas_foto',        -- Pas Foto 3x4
        'ktp_ortu',        -- KTP Orang Tua
        'skl',             -- Surat Keterangan Lulus
        'rapor',           -- Rapor semester terakhir
        'surat_sehat',     -- Surat keterangan sehat
        'kip',             -- Kartu Indonesia Pintar (opsional)
        'lainnya'          -- Dokumen lainnya
    ) NOT NULL COMMENT 'Jenis dokumen yang diupload',
    nama_file VARCHAR(500) NOT NULL COMMENT 'Nama file asli',
    file_path VARCHAR(500) NOT NULL COMMENT 'Path penyimpanan file di server',
    ukuran_file INT UNSIGNED NULL COMMENT 'Ukuran file dalam bytes',
    mime_type VARCHAR(100) NULL COMMENT 'Tipe file: pdf, jpg, png, dll',
    status_verifikasi ENUM('menunggu', 'valid', 'tidak_valid') DEFAULT 'menunggu' COMMENT 'Status verifikasi dokumen',
    catatan VARCHAR(500) NULL COMMENT 'Catatan admin untuk dokumen ini',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (pendaftaran_id) REFERENCES pendaftaran(id) ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Dokumen pendukung yang diupload siswa (Step 5)';


-- ============================================================
-- 9. TABEL PEMBAYARAN (Bukti Pembayaran Pendaftaran)
-- Menyimpan data pembayaran dan bukti transfer
-- ============================================================
CREATE TABLE pembayaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftaran_id BIGINT UNSIGNED NOT NULL COMMENT 'Relasi ke tabel pendaftaran',
    jumlah DECIMAL(12,2) NOT NULL COMMENT 'Jumlah yang dibayarkan',
    metode_pembayaran ENUM('transfer_bank', 'tunai', 'e_wallet') DEFAULT 'transfer_bank' COMMENT 'Metode pembayaran',
    nama_bank VARCHAR(100) NULL COMMENT 'Nama bank pengirim',
    nama_pengirim VARCHAR(255) NULL COMMENT 'Nama pemilik rekening pengirim',
    nomor_rekening VARCHAR(50) NULL COMMENT 'Nomor rekening pengirim',
    bukti_pembayaran_path VARCHAR(500) NULL COMMENT 'Path file bukti pembayaran',
    tanggal_bayar DATE NULL COMMENT 'Tanggal pembayaran dilakukan',
    status ENUM('menunggu', 'terverifikasi', 'ditolak') DEFAULT 'menunggu' COMMENT 'Status verifikasi pembayaran',
    catatan_admin TEXT NULL COMMENT 'Catatan admin terkait pembayaran',
    verified_by BIGINT UNSIGNED NULL COMMENT 'Admin yang memverifikasi',
    verified_at TIMESTAMP NULL COMMENT 'Waktu verifikasi',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (pendaftaran_id) REFERENCES pendaftaran(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON SET NULL
) ENGINE=InnoDB COMMENT='Data pembayaran dan bukti transfer';


-- ============================================================
-- 10. TABEL VERIFIKASI LOG (Riwayat Verifikasi Admin)
-- Mencatat setiap tindakan verifikasi yang dilakukan admin
-- ============================================================
CREATE TABLE verifikasi_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pendaftaran_id BIGINT UNSIGNED NOT NULL COMMENT 'Relasi ke tabel pendaftaran',
    admin_id BIGINT UNSIGNED NOT NULL COMMENT 'Admin yang melakukan verifikasi',
    status_sebelum VARCHAR(50) NULL COMMENT 'Status sebelum diubah',
    status_sesudah VARCHAR(50) NOT NULL COMMENT 'Status setelah diubah',
    catatan TEXT NULL COMMENT 'Catatan/alasan perubahan status',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (pendaftaran_id) REFERENCES pendaftaran(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES users(id)
) ENGINE=InnoDB COMMENT='Log riwayat verifikasi oleh admin';


-- ============================================================
-- 11. TABEL PENGUMUMAN (Pengumuman Hasil Seleksi)
-- Menyimpan data pengumuman yang dipublikasikan
-- ============================================================
CREATE TABLE pengumuman (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengaturan_ppdb_id BIGINT UNSIGNED NOT NULL COMMENT 'Relasi ke periode PPDB',
    judul VARCHAR(255) NOT NULL COMMENT 'Judul pengumuman',
    isi TEXT NOT NULL COMMENT 'Isi pengumuman',
    tanggal_publish TIMESTAMP NULL COMMENT 'Waktu dipublikasikan',
    is_published BOOLEAN DEFAULT FALSE COMMENT 'Status publikasi',
    created_by BIGINT UNSIGNED NULL COMMENT 'Admin yang membuat',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (pengaturan_ppdb_id) REFERENCES pengaturan_ppdb(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
) ENGINE=InnoDB COMMENT='Pengumuman hasil seleksi PPDB';


-- ============================================================
-- INDEKS TAMBAHAN UNTUK PERFORMA QUERY
-- ============================================================
CREATE INDEX idx_pendaftaran_status ON pendaftaran(status);
CREATE INDEX idx_pendaftaran_nomor ON pendaftaran(nomor_pendaftaran);
CREATE INDEX idx_pendaftaran_tanggal ON pendaftaran(tanggal_daftar);
CREATE INDEX idx_siswa_nik ON siswa(nik);
CREATE INDEX idx_siswa_nama ON siswa(nama_lengkap);
CREATE INDEX idx_sekolah_nisn ON sekolah_asal(nisn);
CREATE INDEX idx_dokumen_jenis ON dokumen(pendaftaran_id, jenis_dokumen);
CREATE INDEX idx_pembayaran_status ON pembayaran(status);
CREATE INDEX idx_verifikasi_admin ON verifikasi_log(admin_id, created_at);


-- ============================================================
-- DATA AWAL: AKUN ADMIN DEFAULT
-- Password: admin123 (harus di-hash di Laravel menggunakan bcrypt)
-- ============================================================
INSERT INTO users (nama_lengkap, email, password, role) VALUES
('Admin Utama', 'admin@smknu2medan.sch.id', '$2y$12$placeholderHashedPasswordHere', 'admin');

-- Data periode PPDB
INSERT INTO pengaturan_ppdb (tahun_ajaran, tanggal_buka, tanggal_tutup, tanggal_pengumuman, tanggal_daftar_ulang_mulai, tanggal_daftar_ulang_selesai, biaya_pendaftaran) VALUES
('2026/2027', '2026-01-06', '2026-03-31', '2026-05-15', '2026-06-01', '2026-06-15', 0.00);
