<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->enum('jenis_dokumen', [
                'ijazah',
                'kartu_keluarga',
                'akte_kelahiran',
                'pas_foto',
                'ktp_ortu',
                'skl',
                'rapor',
                'surat_sehat',
                'kip',
                'lainnya',
            ])->comment('Jenis dokumen yang diupload');
            $table->string('nama_file', 500)->comment('Nama file asli');
            $table->string('file_path', 500)->comment('Path penyimpanan file di server');
            $table->unsignedInteger('ukuran_file')->nullable()->comment('Ukuran file dalam bytes');
            $table->string('mime_type', 100)->nullable()->comment('Tipe file: pdf, jpg, png, dll');
            $table->enum('status_verifikasi', ['menunggu', 'valid', 'tidak_valid'])
                ->default('menunggu')
                ->comment('Status verifikasi dokumen');
            $table->string('catatan', 500)->nullable()->comment('Catatan admin untuk dokumen ini');
            $table->timestamps();

            // Indeks
            $table->index(['pendaftaran_id', 'jenis_dokumen'], 'idx_dokumen_jenis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};