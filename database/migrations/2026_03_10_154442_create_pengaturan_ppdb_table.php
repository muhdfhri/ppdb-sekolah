<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaturan_ppdb', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 20)->comment('Tahun ajaran, misal: 2026/2027');
            $table->date('tanggal_buka')->comment('Tanggal pembukaan pendaftaran');
            $table->date('tanggal_tutup')->comment('Tanggal penutupan pendaftaran');
            $table->date('tanggal_pengumuman')->nullable()->comment('Tanggal pengumuman hasil');
            $table->date('tanggal_daftar_ulang_mulai')->nullable()->comment('Tanggal mulai daftar ulang');
            $table->date('tanggal_daftar_ulang_selesai')->nullable()->comment('Tanggal selesai daftar ulang');
            $table->decimal('biaya_pendaftaran', 12, 2)->default(0)->comment('Biaya pendaftaran (0 jika gratis)');
            $table->boolean('is_active')->default(true)->comment('Status periode aktif');
            $table->timestamps();
        });

        // Data awal periode PPDB
        DB::table('pengaturan_ppdb')->insert([
            [
                'tahun_ajaran' => '2026/2027',
                'tanggal_buka' => '2026-01-06',
                'tanggal_tutup' => '2026-03-31',
                'tanggal_pengumuman' => '2026-05-15',
                'tanggal_daftar_ulang_mulai' => '2026-06-01',
                'tanggal_daftar_ulang_selesai' => '2026-06-15',
                'biaya_pendaftaran' => 0.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_ppdb');
    }
};