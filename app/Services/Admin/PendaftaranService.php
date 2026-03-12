<?php

namespace App\Services\Admin;

use App\Models\Pendaftaran;
use App\Models\VerifikasiLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PendaftaranService
{
    // ================================================================
    // UPDATE STATUS (core method)
    // Dipakai oleh: terima(), tolak(), verifikasi()
    // di Admin\PendaftarController
    // ================================================================

    /**
     * Update status pendaftaran dan catat ke verifikasi_log
     *
     * @param Pendaftaran $pendaftaran
     * @param string      $statusBaru   diterima | ditolak | terverifikasi
     * @param string|null $catatan
     */
    public function updateStatus(
        Pendaftaran $pendaftaran,
        string $statusBaru,
        ?string $catatan = null
    ): void {
        DB::transaction(function () use ($pendaftaran, $statusBaru, $catatan) {

            $statusLama = $pendaftaran->status;

            // Update status pendaftaran
            $pendaftaran->update([
                'status' => $statusBaru,
                'catatan_admin' => $catatan,
            ]);

            // Catat log verifikasi
            VerifikasiLog::create([
                'pendaftaran_id' => $pendaftaran->id,
                'admin_id' => Auth::id(),
                'status_sebelum' => $statusLama,
                'status_sesudah' => $statusBaru,
                'catatan' => $catatan,
            ]);
        });
    }

    // ================================================================
    // SHORTCUT METHODS
    // Dipakai langsung dari controller untuk keterbacaan
    // ================================================================

    public function terima(Pendaftaran $pendaftaran, ?string $catatan = null): void
    {
        $this->updateStatus($pendaftaran, Pendaftaran::STATUS_DITERIMA, $catatan);
    }

    public function tolak(Pendaftaran $pendaftaran, string $catatan): void
    {
        $this->updateStatus($pendaftaran, Pendaftaran::STATUS_DITOLAK, $catatan);
    }

    public function verifikasi(Pendaftaran $pendaftaran): void
    {
        $this->updateStatus($pendaftaran, Pendaftaran::STATUS_TERVERIFIKASI, 'Berkas lengkap dan valid');
    }

    // ================================================================
    // QUERY HELPERS
    // Untuk index/filter di Admin\PendaftarController::index()
    // ================================================================

    /**
     * Build query dengan filter search, status, jurusan
     */
    public function buildQuery(array $filters = [])
    {
        $query = Pendaftaran::with(['siswa', 'sekolahAsal', 'jurusan', 'user']);

        // Filter search: nama siswa, NIK, atau NISN
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($sq) use ($search) {
                    $sq->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                })->orWhereHas('sekolahAsal', function ($sq) use ($search) {
                    $sq->where('nisn', 'like', "%{$search}%");
                })->orWhereHas('user', function ($sq) use ($search) {
                    $sq->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        // Filter status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter jurusan
        if (!empty($filters['jurusan_id'])) {
            $query->where('jurusan_id', $filters['jurusan_id']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    // ================================================================
    // STATS UNTUK MINI CARDS
    // Dipakai di Admin\PendaftarController::index()
    // ================================================================

    public function getStats(): array
    {
        return [
            'total' => Pendaftaran::count(),
            'diterima' => Pendaftaran::where('status', Pendaftaran::STATUS_DITERIMA)->count(),
            'ditolak' => Pendaftaran::where('status', Pendaftaran::STATUS_DITOLAK)->count(),
            'menunggu' => Pendaftaran::where('status', Pendaftaran::STATUS_MENUNGGU_VERIFIKASI)->count(),
            'draft' => Pendaftaran::where('status', Pendaftaran::STATUS_DRAFT)->count(),
        ];
    }
}