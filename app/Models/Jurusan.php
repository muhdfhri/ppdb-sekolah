<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'deskripsi',
        'kuota',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'kuota' => 'integer',
    ];

    // ── Relasi ──────────────────────────────────────────────

    /** Pendaftaran yang memilih jurusan ini sebagai pilihan 1 */
    public function pendaftaranPilihan1(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'jurusan_id');
    }

    /** Pendaftaran yang memilih jurusan ini sebagai pilihan 2 */
    public function pendaftaranPilihan2(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'jurusan_id_2');
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
}