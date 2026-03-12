<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->decimal('jumlah', 12, 2)->comment('Jumlah yang dibayarkan');
            $table->enum('metode_pembayaran', ['transfer_bank', 'tunai', 'e_wallet'])
                ->default('transfer_bank')
                ->comment('Metode pembayaran');
            $table->string('nama_bank', 100)->nullable()->comment('Nama bank pengirim');
            $table->string('nama_pengirim')->nullable()->comment('Nama pemilik rekening pengirim');
            $table->string('nomor_rekening', 50)->nullable()->comment('Nomor rekening pengirim');
            $table->string('bukti_pembayaran_path', 500)->nullable()->comment('Path file bukti pembayaran');
            $table->date('tanggal_bayar')->nullable()->comment('Tanggal pembayaran dilakukan');
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak'])
                ->default('menunggu')
                ->comment('Status verifikasi pembayaran');
            $table->text('catatan_admin')->nullable()->comment('Catatan admin terkait pembayaran');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable()->comment('Waktu verifikasi');
            $table->timestamps();

            // Indeks
            $table->index('status', 'idx_pembayaran_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};