<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('pengaturan_ppdb_id')->constrained('pengaturan_ppdb');
            $table->foreignId('jurusan_id')->constrained('jurusan');
            $table->foreignId('jurusan_id_2')->nullable()->constrained('jurusan');
            $table->string('nomor_pendaftaran', 30)->unique()->comment('Nomor unik, misal: PPDB-2026-0001');
            $table->timestamp('tanggal_daftar')->useCurrent()->comment('Waktu pendaftaran');
            $table->enum('status', [
                'draft',
                'menunggu_pembayaran',
                'menunggu_verifikasi',
                'terverifikasi',
                'diterima',
                'ditolak',
                'cadangan',
            ])->default('draft')->comment('Status pendaftaran');
            $table->text('catatan_admin')->nullable()->comment('Catatan dari admin saat verifikasi');
            $table->unsignedTinyInteger('step_terakhir')->default(1)->comment('Step form terakhir yang diisi (1-5)');
            $table->timestamps();

            // Indeks
            $table->index('status', 'idx_pendaftaran_status');
            $table->index('nomor_pendaftaran', 'idx_pendaftaran_nomor');
            $table->index('tanggal_daftar', 'idx_pendaftaran_tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};