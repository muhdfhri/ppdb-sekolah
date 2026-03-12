<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftaran')->cascadeOnDelete();
            $table->string('nik', 16)->comment('Nomor Induk Kependudukan (16 digit)');
            $table->string('nama_lengkap')->comment('Nama lengkap sesuai akta/ijazah');
            $table->string('tempat_lahir', 100)->comment('Tempat lahir');
            $table->date('tanggal_lahir')->comment('Tanggal lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->comment('Jenis kelamin');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->default('Islam');
            $table->text('alamat_lengkap')->comment('Alamat lengkap (jalan, RT/RW, kelurahan, kecamatan)');
            $table->string('no_telepon', 20)->nullable()->comment('Nomor HP siswa');
            $table->string('email')->nullable()->comment('Email siswa');
            $table->string('foto_path', 500)->nullable()->comment('Path file foto pas siswa');
            $table->timestamps();

            // Indeks
            $table->index('nik', 'idx_siswa_nik');
            $table->index('nama_lengkap', 'idx_siswa_nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};