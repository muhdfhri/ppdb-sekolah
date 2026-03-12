<?php

namespace App\Services\Admin;

use App\Models\Jurusan;
use App\Models\Pendaftaran;

class JurusanService
{
    // ================================================================
    // CREATE
    // Dipanggil dari Admin\JurusanController::store()
    // ================================================================

    public function create(array $data): Jurusan
    {
        return Jurusan::create([
            'kode_jurusan' => strtoupper($data['kode_jurusan']),
            'nama_jurusan' => $data['nama_jurusan'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'kuota' => $data['kuota'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    // ================================================================
    // UPDATE
    // Dipanggil dari Admin\JurusanController::update()
    // ================================================================

    public function update(Jurusan $jurusan, array $data): Jurusan
    {
        $jurusan->update([
            'kode_jurusan' => strtoupper($data['kode_jurusan']),
            'nama_jurusan' => $data['nama_jurusan'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'kuota' => $data['kuota'],
        ]);

        return $jurusan->fresh();
    }

    // ================================================================
    // TOGGLE ACTIVE
    // Dipanggil dari Admin\JurusanController::toggleActive() via AJAX
    // ================================================================

    public function toggleActive(Jurusan $jurusan): Jurusan
    {
        $jurusan->update(['is_active' => !$jurusan->is_active]);

        return $jurusan->fresh();
    }

    // ================================================================
    // UPDATE KUOTA BULK
    // Dipanggil dari Admin\PengaturanController::updateKuota()
    // ================================================================

    /**
     * Update kuota dan status aktif banyak jurusan sekaligus
     *
     * @param array $kuotaMap  [jurusan_id => kuota]
     * @param array $aktifMap  [jurusan_id => true] (dari checkbox)
     */
    public function updateKuotaBulk(array $kuotaMap, array $aktifMap = []): void
    {
        foreach ($kuotaMap as $id => $kuota) {
            $jurusan = Jurusan::find($id);
            if (!$jurusan)
                continue;

            $jurusan->update([
                'kuota' => (int) $kuota,
                'is_active' => isset($aktifMap[$id]),
            ]);
        }
    }

    // ================================================================
    // STATISTIK JURUSAN
    // Untuk rekap laporan dan pengaturan
    // ================================================================

    public function getStatsPerJurusan(): array
    {
        $jurusanList = Jurusan::all();
        $result = [];

        foreach ($jurusanList as $jurusan) {
            $baseQuery = Pendaftaran::where('jurusan_id', $jurusan->id);

            $result[] = [
                'id' => $jurusan->id,
                'kode' => $jurusan->kode_jurusan,
                'nama' => $jurusan->nama_jurusan,
                'kuota' => $jurusan->kuota,
                'is_active' => $jurusan->is_active,
                'total' => (clone $baseQuery)->count(),
                'diterima' => (clone $baseQuery)->where('status', 'diterima')->count(),
                'menunggu' => (clone $baseQuery)->where('status', 'menunggu_verifikasi')->count(),
                'ditolak' => (clone $baseQuery)->where('status', 'ditolak')->count(),
                'sisa_kuota' => $jurusan->kuota - (clone $baseQuery)->where('status', 'diterima')->count(),
            ];
        }

        return $result;
    }
}