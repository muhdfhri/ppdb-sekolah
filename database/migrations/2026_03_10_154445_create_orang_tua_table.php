<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->enum('jenis', ['ayah', 'ibu', 'wali'])->comment('Jenis: ayah, ibu, atau wali');
            $table->string('nama_lengkap')->comment('Nama lengkap orang tua/wali');
            $table->string('nik', 16)->nullable()->comment('NIK orang tua/wali');
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('pekerjaan')->nullable()->comment('Pekerjaan orang tua/wali');
            $table->enum('penghasilan', [
                'kurang_1jt',
                '1jt_3jt',
                '3jt_5jt',
                '5jt_10jt',
                'lebih_10jt',
            ])->nullable()->comment('Range penghasilan per bulan');
            $table->string('no_telepon', 20)->nullable()->comment('Nomor HP orang tua/wali');
            $table->text('alamat')->nullable()->comment('Alamat orang tua/wali');
            $table->timestamps();

            // Unique: satu pendaftaran hanya boleh 1 ayah, 1 ibu, 1 wali
            $table->unique(['pendaftaran_id', 'jenis'], 'unique_ortu');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orang_tua');
    }
};