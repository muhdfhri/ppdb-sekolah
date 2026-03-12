<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sekolah_asal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftaran')->cascadeOnDelete();
            $table->string('nisn', 20)->nullable()->comment('Nomor Induk Siswa Nasional');
            $table->string('nama_sekolah')->comment('Nama sekolah asal (SMP/MTs)');
            $table->text('alamat_sekolah')->nullable()->comment('Alamat sekolah asal');
            $table->year('tahun_lulus')->comment('Tahun kelulusan');
            $table->decimal('nilai_rata_rata', 5, 2)->nullable()->comment('Nilai rata-rata rapor/ijazah');
            $table->timestamps();

            // Indeks
            $table->index('nisn', 'idx_sekolah_nisn');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolah_asal');
    }
};