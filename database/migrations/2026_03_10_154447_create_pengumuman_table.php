<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaturan_ppdb_id')->constrained('pengaturan_ppdb');
            $table->string('judul')->comment('Judul pengumuman');
            $table->text('isi')->comment('Isi pengumuman');
            $table->timestamp('tanggal_publish')->nullable()->comment('Waktu dipublikasikan');
            $table->boolean('is_published')->default(false)->comment('Status publikasi');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};