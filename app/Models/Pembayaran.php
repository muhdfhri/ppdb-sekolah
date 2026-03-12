<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'pendaftaran_id',
        'jumlah',
        'metode_pembayaran',
        'nama_bank',
        'nama_pengirim',
        'nomor_rekening',
        'bukti_pembayaran_path',
        'tanggal_bayar',
        'status',
        'catatan_admin',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_bayar' => 'date',
        'verified_at' => 'datetime',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeTerverifikasi($query)
    {
        return $query->where('status', 'terverifikasi');
    }

    // ── Helpers ─────────────────────────────────────────────

    public function getBuktiUrlAttribute(): ?string
    {
        return $this->bukti_pembayaran_path
            ? asset('storage/' . $this->bukti_pembayaran_path)
            : null;
    }
}