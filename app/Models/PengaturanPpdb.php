<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengaturanPpdb extends Model
{
    protected $table = 'pengaturan_ppdb';

    protected $fillable = [
        'tahun_ajaran',
        'tanggal_buka',
        'tanggal_tutup',
        'tanggal_pengumuman',
        'tanggal_daftar_ulang_mulai',
        'tanggal_daftar_ulang_selesai',
        'biaya_pendaftaran',
        'is_active',
    ];

    protected $casts = [
        'tanggal_buka' => 'date',
        'tanggal_tutup' => 'date',
        'tanggal_pengumuman' => 'date',
        'tanggal_daftar_ulang_mulai' => 'date',
        'tanggal_daftar_ulang_selesai' => 'date',
        'biaya_pendaftaran' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'pengaturan_ppdb_id');
    }

    public function pengumuman(): HasMany
    {
        return $this->hasMany(Pengumuman::class, 'pengaturan_ppdb_id');
    }

    // ── Scopes ──────────────────────────────────────────────

    /**
     * Mendapatkan periode yang aktif (bisa multiple)
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Mendapatkan periode yang sedang berlangsung (tanggal buka <= sekarang <= tanggal tutup)
     */
    public function scopeSedangBerlangsung($query)
    {
        $now = now()->toDateString();
        return $query->where('tanggal_buka', '<=', $now)
            ->where('tanggal_tutup', '>=', $now);
    }

    // ── Helpers ─────────────────────────────────────────────

    /** Cek apakah saat ini masa pendaftaran masih buka */
    public function isBuka(): bool
    {
        $now = now()->toDateString();
        return $now >= $this->tanggal_buka->toDateString()
            && $now <= $this->tanggal_tutup->toDateString();
    }
}