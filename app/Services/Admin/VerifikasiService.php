<?php

namespace App\Services\Admin;

use App\Models\Dokumen;
use App\Models\Pendaftaran;
use App\Models\VerifikasiLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiService
{
    // ================================================================
    // VERIFIKASI SATU DOKUMEN
    // Dipanggil dari Admin\VerifikasiController::verifikasiDokumen()
    // ================================================================

    /**
     * Set status verifikasi sebuah dokumen
     *
     * @param Dokumen $dokumen
     * @param string  $status    valid | tidak_valid
     * @param string|null $catatan
     */
    public function verifikasiDokumen(
        Dokumen $dokumen,
        string $status,
        ?string $catatan = null
    ): Dokumen {
        $dokumen->update([
            'status_verifikasi' => $status,
            'catatan' => $catatan,
        ]);

        return $dokumen->fresh();
    }

    // ================================================================
    // CEK KELENGKAPAN SEMUA DOKUMEN WAJIB
    // Dipakai sebelum admin bisa set status 'terverifikasi'
    // ================================================================

    /**
     * Return true jika semua dokumen wajib sudah berstatus 'valid'
     */
    public function isDokumenLengkap(Pendaftaran $pendaftaran): bool
    {
        $wajib = ['ijazah', 'kartu_keluarga', 'akte_kelahiran', 'pas_foto'];

        $validCount = $pendaftaran->dokumen()
            ->whereIn('jenis_dokumen', $wajib)
            ->where('status_verifikasi', 'valid')
            ->count();

        return $validCount === count($wajib);
    }

    // ================================================================
    // VERIFIKASI SEMUA DOKUMEN SEKALIGUS
    // Bulk action — set semua dokumen pending menjadi valid
    // ================================================================

    public function verifikasiSemuaDokumen(Pendaftaran $pendaftaran): void
    {
        $pendaftaran->dokumen()
            ->where('status_verifikasi', 'menunggu')
            ->update(['status_verifikasi' => 'valid']);
    }

    // ================================================================
    // SUMMARY DOKUMEN
    // Untuk ditampilkan di view verifikasi
    // ================================================================

    public function getSummaryDokumen(Pendaftaran $pendaftaran): array
    {
        $dokumen = $pendaftaran->dokumen;

        return [
            'total' => $dokumen->count(),
            'valid' => $dokumen->where('status_verifikasi', 'valid')->count(),
            'tidak_valid' => $dokumen->where('status_verifikasi', 'tidak_valid')->count(),
            'menunggu' => $dokumen->where('status_verifikasi', 'menunggu')->count(),
        ];
    }

    // ================================================================
    // DAFTAR PENDAFTARAN MENUNGGU VERIFIKASI
    // Untuk Admin\VerifikasiController::index()
    // ================================================================

    public function getPendingVerifikasi(int $perPage = 20)
    {
        return Pendaftaran::with(['siswa', 'jurusan', 'dokumen'])
            ->where('status', Pendaftaran::STATUS_MENUNGGU_VERIFIKASI)
            ->orderBy('tanggal_daftar', 'asc') // FIFO — yang lebih lama diproses duluan
            ->paginate($perPage);
    }
}