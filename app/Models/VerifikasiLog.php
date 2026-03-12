<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifikasiLog extends Model
{
    protected $table = 'verifikasi_log';

    // Tabel ini tidak punya updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'pendaftaran_id',
        'admin_id',
        'status_sebelum',
        'status_sesudah',
        'catatan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}