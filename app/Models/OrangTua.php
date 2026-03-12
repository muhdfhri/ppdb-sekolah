<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrangTua extends Model
{
    protected $table = 'orang_tua';

    protected $fillable = [
        'pendaftaran_id',
        'jenis',
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'pekerjaan',
        'penghasilan',
        'no_telepon',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Penghasilan constants
    const PENGHASILAN_KURANG_1JT = 'kurang_1jt';
    const PENGHASILAN_1JT_3JT = '1jt_3jt';
    const PENGHASILAN_3JT_5JT = '3jt_5jt';
    const PENGHASILAN_5JT_10JT = '5jt_10jt';
    const PENGHASILAN_LEBIH_10JT = 'lebih_10jt';

    public static array $labelPenghasilan = [
        'kurang_1jt' => 'Kurang dari Rp 1.000.000',
        '1jt_3jt' => 'Rp 1.000.000 – Rp 3.000.000',
        '3jt_5jt' => 'Rp 3.000.000 – Rp 5.000.000',
        '5jt_10jt' => 'Rp 5.000.000 – Rp 10.000.000',
        'lebih_10jt' => 'Lebih dari Rp 10.000.000',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeAyah($query)
    {
        return $query->where('jenis', 'ayah');
    }

    public function scopeIbu($query)
    {
        return $query->where('jenis', 'ibu');
    }

    public function scopeWali($query)
    {
        return $query->where('jenis', 'wali');
    }

    // ── Helpers ─────────────────────────────────────────────

    public function getLabelPenghasilanAttribute(): string
    {
        return self::$labelPenghasilan[$this->penghasilan] ?? '—';
    }
}