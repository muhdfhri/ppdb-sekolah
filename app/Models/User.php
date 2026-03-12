<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ── Role Helpers ────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    // ── Relasi ──────────────────────────────────────────────

    /** Pendaftaran milik siswa ini */
    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'user_id');
    }

    /** Pendaftaran aktif (hanya 1 per periode) */
    public function pendaftaranAktif(): HasOne
    {
        return $this->hasOne(Pendaftaran::class, 'user_id')->latestOfMany();
    }

    /** Log verifikasi yang dilakukan admin ini */
    public function verifikasiLog(): HasMany
    {
        return $this->hasMany(VerifikasiLog::class, 'admin_id');
    }

    /** Pembayaran yang diverifikasi admin ini */
    public function pembayaranDiverifikasi(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'verified_by');
    }

    /** Pengumuman yang dibuat admin ini */
    public function pengumuman(): HasMany
    {
        return $this->hasMany(Pengumuman::class, 'created_by');
    }
}