<?php

namespace App\Services\Siswa;

use App\Models\User;
use App\Models\PengaturanPpdb;
use App\Models\Pengumuman;

class DashboardService
{
    /**
     * Ambil semua data yang diperlukan untuk dashboard siswa
     */
    public function getSiswaData(User $user): array
    {
        $pendaftaran = $user->pendaftaranAktif()
                ?->with(['siswa', 'sekolahAsal', 'jurusan', 'dokumen', 'verifikasiLog'])
            ->first();

        $ppdbAktif = PengaturanPpdb::aktif()->first();

        $pengumuman = Pengumuman::published()
            ->latest('tanggal_publish')
            ->take(5)
            ->get();

        return [
            'pendaftaran' => $pendaftaran,
            'ppdb' => $ppdbAktif,
            'pengumuman' => $pengumuman,
            'progres' => $this->hitungProgres($pendaftaran),
        ];
    }

    /**
     * Hitung persentase kelengkapan pendaftaran (1–5 step)
     */
    public function hitungProgres(?object $pendaftaran): int
    {
        if (!$pendaftaran)
            return 0;

        $steps = 0;

        // Step 1 — Data Pribadi (via relasi siswa)
        if ($pendaftaran->siswa)
            $steps++;

        // Step 2 — Sekolah Asal
        if ($pendaftaran->sekolahAsal)
            $steps++;

        // Step 3 — Orang Tua (cek lewat relasi orangTua / ayah)
        if ($pendaftaran->orangTua && $pendaftaran->orangTua->isNotEmpty())
            $steps++;

        // Step 4 — Jurusan
        if ($pendaftaran->jurusan_pilihan_1_id)
            $steps++;

        // Step 5 — Dokumen
        if ($pendaftaran->dokumen && $pendaftaran->dokumen->isNotEmpty())
            $steps++;

        return (int) round(($steps / 5) * 100);
    }
}