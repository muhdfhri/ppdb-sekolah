<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('verifikasi_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('users');
            $table->string('status_sebelum', 50)->nullable()->comment('Status sebelum diubah');
            $table->string('status_sesudah', 50)->comment('Status setelah diubah');
            $table->text('catatan')->nullable()->comment('Catatan/alasan perubahan status');
            $table->timestamp('created_at')->useCurrent();

            // Indeks
            $table->index(['admin_id', 'created_at'], 'idx_verifikasi_admin');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_log');
    }
};