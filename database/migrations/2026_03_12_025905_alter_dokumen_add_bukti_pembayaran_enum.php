<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Tambah 'bukti_pembayaran' ke ENUM jenis_dokumen
        DB::statement("
            ALTER TABLE dokumen
            MODIFY COLUMN jenis_dokumen ENUM(
                'ijazah',
                'kartu_keluarga',
                'akte_kelahiran',
                'pas_foto',
                'ktp_ortu',
                'skl',
                'rapor',
                'surat_sehat',
                'kip',
                'bukti_pembayaran',
                'lainnya'
            ) NOT NULL COMMENT 'Jenis dokumen yang diupload'
        ");
    }

    public function down(): void
    {
        // Kembalikan ENUM tanpa 'bukti_pembayaran'
        // Pastikan tidak ada row dengan value 'bukti_pembayaran' sebelum rollback
        DB::statement("
            ALTER TABLE dokumen
            MODIFY COLUMN jenis_dokumen ENUM(
                'ijazah',
                'kartu_keluarga',
                'akte_kelahiran',
                'pas_foto',
                'ktp_ortu',
                'skl',
                'rapor',
                'surat_sehat',
                'kip',
                'lainnya'
            ) NOT NULL COMMENT 'Jenis dokumen yang diupload'
        ");
    }
};