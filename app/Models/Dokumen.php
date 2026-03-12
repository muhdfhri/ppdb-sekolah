<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    protected $table = 'dokumen';

    protected $fillable = [
        'pendaftaran_id',
        'jenis_dokumen',
        'nama_file',
        'file_path',
        'ukuran_file',
        'mime_type',
        'status_verifikasi',
        'catatan',
    ];

    protected $casts = [
        'ukuran_file' => 'integer',
    ];

    public static array $labelJenis = [
        'ijazah' => 'Ijazah / SKL',
        'kartu_keluarga' => 'Kartu Keluarga',
        'akte_kelahiran' => 'Akta Kelahiran',
        'pas_foto' => 'Pas Foto 3x4',
        'ktp_ortu' => 'KTP Orang Tua',
        'skl' => 'Surat Keterangan Lulus',
        'rapor' => 'Rapor Semester Terakhir',
        'surat_sehat' => 'Surat Keterangan Sehat',
        'kip' => 'Kartu Indonesia Pintar',
        'bukti_pembayaran' => 'Bukti Pembayaran',
        'lainnya' => 'Dokumen Lainnya',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeMenunggu($query)
    {
        return $query->where('status_verifikasi', 'menunggu');
    }

    public function scopeValid($query)
    {
        return $query->where('status_verifikasi', 'valid');
    }

    // ── Helpers ─────────────────────────────────────────────

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function getUkuranFormatAttribute(): string
    {
        if (!$this->ukuran_file)
            return '—';
        $kb = $this->ukuran_file / 1024;
        return $kb >= 1024
            ? number_format($kb / 1024, 2) . ' MB'
            : number_format($kb, 1) . ' KB';
    }

    public function getLabelJenisAttribute(): string
    {
        return self::$labelJenis[$this->jenis_dokumen] ?? $this->jenis_dokumen;
    }
}