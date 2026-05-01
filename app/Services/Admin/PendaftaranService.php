<?php

namespace App\Services\Admin;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PendaftaranService
{
    /**
     * Build query with filters
     */
    public function buildQuery(array $filters = [])
    {
        $query = Pendaftaran::with(['user', 'siswa', 'jurusan']);

        // Search by name or registration number
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pendaftaran', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('nama_lengkap', 'like', "%{$search}%");
                    })
                    ->orWhereHas('siswa', function ($q2) use ($search) {
                        $q2->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status (hanya status yang ada di enum: diterima, ditolak, menunggu_verifikasi)
        if (!empty($filters['status']) && in_array($filters['status'], ['diterima', 'ditolak', 'menunggu_verifikasi'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by jurusan
        if (!empty($filters['jurusan_id'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('jurusan_id', $filters['jurusan_id'])
                    ->orWhere('jurusan_id_2', $filters['jurusan_id']);
            });
        }

        return $query->latest('tanggal_daftar');
    }

    /**
     * Get statistics for dashboard
     */
    public function getStats()
    {
        return [
            'total' => Pendaftaran::count(),
            'menunggu_verifikasi' => Pendaftaran::where('status', 'menunggu_verifikasi')->count(),
            'diterima' => Pendaftaran::where('status', 'diterima')->count(),
            'ditolak' => Pendaftaran::where('status', 'ditolak')->count(),
        ];
    }

    /**
     * Accept registration
     */
    public function terima(Pendaftaran $pendaftaran, ?string $catatan = null)
    {
        DB::transaction(function () use ($pendaftaran, $catatan) {
            // Simpan status sebelumnya
            $statusSebelum = $pendaftaran->status;

            // Update status
            $pendaftaran->update([
                'status' => 'diterima',
                'catatan_admin' => $catatan,
            ]);

            // Catat ke log verifikasi
            $pendaftaran->verifikasiLog()->create([
                'admin_id' => auth()->id(),
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => 'diterima',
                'catatan' => $catatan ?? 'Pendaftaran diterima.',
            ]);
        });
    }

    /**
     * Reject registration
     */
    public function tolak(Pendaftaran $pendaftaran, string $catatan)
    {
        DB::transaction(function () use ($pendaftaran, $catatan) {
            // Simpan status sebelumnya
            $statusSebelum = $pendaftaran->status;

            // Update status
            $pendaftaran->update([
                'status' => 'ditolak',
                'catatan_admin' => $catatan,
            ]);

            // Catat ke log verifikasi
            $pendaftaran->verifikasiLog()->create([
                'admin_id' => auth()->id(),
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => 'ditolak',
                'catatan' => $catatan,
            ]);
        });
    }

    /**
     * Verify documents (only for menunggu_verifikasi status)
     */
    public function verifikasi(Pendaftaran $pendaftaran)
    {
        // Fungsi ini bisa digunakan untuk verifikasi berkas
        // atau bisa diintegrasikan dengan proses penerimaan/penolakan

        DB::transaction(function () use ($pendaftaran) {
            // Catat ke log verifikasi
            $pendaftaran->verifikasiLog()->create([
                'admin_id' => auth()->id(),
                'status_sebelum' => $pendaftaran->status,
                'status_sesudah' => $pendaftaran->status,
                'catatan' => 'Berkas telah diverifikasi oleh admin.',
            ]);
        });
    }
}