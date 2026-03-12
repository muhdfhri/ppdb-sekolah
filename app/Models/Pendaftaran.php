<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'user_id',
        'pengaturan_ppdb_id',
        'jurusan_id',
        'jurusan_id_2',
        'nomor_pendaftaran',
        'tanggal_daftar',
        'status',
        'catatan_admin',
        'step_terakhir',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
        'step_terakhir' => 'integer',
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';
    const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    const STATUS_TERVERIFIKASI = 'terverifikasi';
    const STATUS_DITERIMA = 'diterima';
    const STATUS_DITOLAK = 'ditolak';
    const STATUS_CADANGAN = 'cadangan';

    // ── Relasi ──────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pengaturanPpdb(): BelongsTo
    {
        return $this->belongsTo(PengaturanPpdb::class, 'pengaturan_ppdb_id');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function jurusanPilihan2(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id_2');
    }

    public function siswa(): HasOne
    {
        return $this->hasOne(Siswa::class, 'pendaftaran_id');
    }

    public function sekolahAsal(): HasOne
    {
        return $this->hasOne(SekolahAsal::class, 'pendaftaran_id');
    }

    public function orangTua(): HasMany
    {
        return $this->hasMany(OrangTua::class, 'pendaftaran_id');
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'pendaftaran_id');
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'pendaftaran_id');
    }

    public function verifikasiLog(): HasMany
    {
        return $this->hasMany(VerifikasiLog::class, 'pendaftaran_id');
    }

    // ── Helpers ─────────────────────────────────────────────

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_TERVERIFIKASI => 'Terverifikasi',
            self::STATUS_DITERIMA => 'Diterima',
            self::STATUS_DITOLAK => 'Ditolak',
            self::STATUS_CADANGAN => 'Cadangan',
            default => ucfirst($this->status),
        };
    }

    /** Generate nomor pendaftaran: PPDB-2026-0001 */
    public static function generateNomor(string $tahun): string
    {
        $last = static::whereYear('created_at', $tahun)
            ->orderBy('id', 'desc')
            ->first();

        if ($last) {
            $lastNumber = intval(substr($last->nomor_pendaftaran, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return 'PPDB-' . $tahun . '-' . $newNumber;
    }
}