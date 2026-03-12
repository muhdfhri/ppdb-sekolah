<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'pengaturan_ppdb_id',
        'judul',
        'isi',
        'tanggal_publish',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'tanggal_publish' => 'datetime',
        'is_published' => 'boolean',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function pengaturanPpdb(): BelongsTo
    {
        return $this->belongsTo(PengaturanPpdb::class, 'pengaturan_ppdb_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('tanggal_publish', '<=', now());
    }
}