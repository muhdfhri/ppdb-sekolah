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

    // ── Boot Method untuk Cascade Delete ─────────────────────

    /**
     * The "booted" method of the model.
     * Menangani cascade delete secara otomatis
     */
    protected static function booted()
    {
        static::deleting(function ($pendaftaran) {
            // Hapus data siswa terkait
            if ($pendaftaran->siswa) {
                $pendaftaran->siswa->delete();
            }

            // Hapus data sekolah asal terkait
            if ($pendaftaran->sekolahAsal) {
                $pendaftaran->sekolahAsal->delete();
            }

            // Hapus semua data orang tua terkait
            if ($pendaftaran->orangTua->count() > 0) {
                $pendaftaran->orangTua()->delete();
            }

            // Hapus semua dokumen terkait (termasuk file fisiknya)
            if ($pendaftaran->dokumen->count() > 0) {
                foreach ($pendaftaran->dokumen as $dokumen) {
                    // Hapus file fisik jika ada
                    if ($dokumen->file_path && \Storage::exists($dokumen->file_path)) {
                        \Storage::delete($dokumen->file_path);
                    }
                }
                $pendaftaran->dokumen()->delete();
            }

            // Hapus semua data pembayaran terkait
            if ($pendaftaran->pembayaran->count() > 0) {
                $pendaftaran->pembayaran()->delete();
            }

            // Hapus semua log verifikasi terkait
            if ($pendaftaran->verifikasiLog->count() > 0) {
                $pendaftaran->verifikasiLog()->delete();
            }
        });
    }

    // ── Tambahan Method untuk Delete dengan Validasi ────────

    /**
     * Cek apakah pendaftaran bisa dihapus
     * Hanya status tertentu yang boleh dihapus
     */
    public function canBeDeleted(): bool
    {
        return in_array($this->status, [
            self::STATUS_DRAFT,
            self::STATUS_MENUNGGU_PEMBAYARAN,
            self::STATUS_MENUNGGU_VERIFIKASI
        ]);
    }

    /**
     * Hapus pendaftaran beserta semua data terkait dengan validasi
     */
    public function deleteWithRelations(): bool
    {
        if (!$this->canBeDeleted()) {
            throw new \Exception('Pendaftaran dengan status "' . $this->label_status . '" tidak dapat dihapus.');
        }

        return $this->delete();
    }

    /**
     * Soft info sebelum hapus - untuk keperluan logging/notification
     */
    public function getDeleteInfo(): array
    {
        return [
            'nomor_pendaftaran' => $this->nomor_pendaftaran,
            'nama_siswa' => $this->siswa?->nama_lengkap ?? 'Tidak ada data',
            'status' => $this->label_status,
            'tanggal_daftar' => $this->tanggal_daftar?->format('d/m/Y'),
            'relasi_data' => [
                'siswa' => $this->siswa ? 'Akan dihapus' : '-',
                'sekolah_asal' => $this->sekolahAsal ? 'Akan dihapus' : '-',
                'orang_tua' => $this->orangTua->count(),
                'dokumen' => $this->dokumen->count(),
                'pembayaran' => $this->pembayaran->count(),
                'verifikasi_log' => $this->verifikasiLog->count(),
            ]
        ];
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