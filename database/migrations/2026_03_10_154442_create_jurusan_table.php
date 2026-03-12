<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jurusan', 10)->unique()->comment('Kode singkat jurusan, misal: TKJ');
            $table->string('nama_jurusan')->comment('Nama lengkap jurusan');
            $table->text('deskripsi')->nullable()->comment('Deskripsi jurusan');
            $table->unsignedInteger('kuota')->default(0)->comment('Kuota maksimal siswa per jurusan');
            $table->boolean('is_active')->default(true)->comment('Status aktif jurusan');
            $table->timestamps();
        });

        // Data awal jurusan
        DB::table('jurusan')->insert([
            ['kode_jurusan' => 'TKJ', 'nama_jurusan' => 'Teknik Komputer & Jaringan', 'deskripsi' => 'Mempelajari instalasi, konfigurasi, dan troubleshooting jaringan komputer', 'kuota' => 120, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode_jurusan' => 'AKL', 'nama_jurusan' => 'Akuntansi & Keuangan Lembaga', 'deskripsi' => 'Mempelajari prinsip akuntansi, keuangan, dan perpajakan', 'kuota' => 80, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode_jurusan' => 'BDP', 'nama_jurusan' => 'Bisnis Daring & Pemasaran', 'deskripsi' => 'Mempelajari strategi bisnis online dan pemasaran digital', 'kuota' => 80, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode_jurusan' => 'MM', 'nama_jurusan' => 'Multimedia', 'deskripsi' => 'Mempelajari desain grafis, animasi, dan produksi konten digital', 'kuota' => 80, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};