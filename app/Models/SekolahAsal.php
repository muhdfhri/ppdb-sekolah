<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SekolahAsal extends Model
{
    protected $table = 'sekolah_asal';

    protected $fillable = [
        'pendaftaran_id',
        'nisn',
        'nama_sekolah',
        'alamat_sekolah',
        'tahun_lulus',
        'nilai_rata_rata',
    ];

    protected $casts = [
        'nilai_rata_rata' => 'decimal:2',
        'tahun_lulus' => 'integer',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }
}