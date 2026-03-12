<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'pendaftaran_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat_lengkap',
        'no_telepon',
        'email',
        'foto_path',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    // ── Helpers ─────────────────────────────────────────────

    /** URL foto atau placeholder */
    public function getFotoUrlAttribute(): string
    {
        return $this->foto_path
            ? asset('storage/' . $this->foto_path)
            : asset('images/placeholder-foto.png');
    }

    /** Usia siswa */
    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir->age;
    }
}