<?php

namespace App\Services\Admin;

use App\Models\Pendaftaran;
use App\Models\VerifikasiLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    // ================================================================
    // STATS UTAMA
    // ================================================================

    /**
     * Semua stats untuk dashboard admin
     * Dipanggil dari Admin\DashboardController::index()
     */
    public function getStats(): array
    {
        return [
            'total' => Pendaftaran::count(),
            'diterima' => Pendaftaran::where('status', 'diterima')->count(),
            'ditolak' => Pendaftaran::where('status', 'ditolak')->count(),
            'menunggu' => Pendaftaran::where('status', 'menunggu_verifikasi')->count(),
            'draft' => Pendaftaran::where('status', 'draft')->count(),
            'growth' => $this->getGrowthPercentage(),
            'avg_per_day' => $this->getAveragePerDay(),
        ];
    }

    // ================================================================
    // GROWTH PERCENTAGE
    // Bandingkan total pendaftar bulan ini vs bulan lalu
    // ================================================================

    public function getGrowthPercentage(): int
    {
        $bulanIni = Pendaftaran::whereMonth('tanggal_daftar', now()->month)
            ->whereYear('tanggal_daftar', now()->year)
            ->count();

        $bulanLalu = Pendaftaran::whereMonth('tanggal_daftar', now()->subMonth()->month)
            ->whereYear('tanggal_daftar', now()->subMonth()->year)
            ->count();

        if ($bulanLalu === 0) {
            return $bulanIni > 0 ? 100 : 0;
        }

        return (int) round((($bulanIni - $bulanLalu) / $bulanLalu) * 100);
    }

    // ================================================================
    // AVERAGE PENDAFTAR PER HARI
    // Hitung dari awal bulan sampai hari ini
    // ================================================================

    public function getAveragePerDay(): int
    {
        $hariIni = now()->day;
        $totalBulanIni = Pendaftaran::whereMonth('tanggal_daftar', now()->month)
            ->whereYear('tanggal_daftar', now()->year)
            ->count();

        if ($hariIni === 0)
            return 0;

        return (int) round($totalBulanIni / $hariIni);
    }

    // ================================================================
    // TREN MINGGUAN
    // Jumlah pendaftar 7 hari terakhir (Senin - Minggu minggu ini)
    // ================================================================

    public function getTrenMingguan(): array
    {
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY);

        $data = Pendaftaran::select(
            DB::raw('DAYOFWEEK(tanggal_daftar) as hari'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('tanggal_daftar', [
                $startOfWeek,
                $startOfWeek->copy()->endOfWeek(),
            ])
            ->groupBy('hari')
            ->pluck('total', 'hari')
            ->toArray();

        // MySQL: 1=Minggu, 2=Senin, ..., 7=Sabtu
        // Kita mapping ke index 0=Senin ... 6=Minggu
        $result = [];
        $mysqlOffset = [2, 3, 4, 5, 6, 7, 1]; // Senin=2 ... Minggu=1

        foreach ($mysqlOffset as $mysqlDay) {
            $result[] = $data[$mysqlDay] ?? 0;
        }

        return $result; // [senin, selasa, rabu, kamis, jumat, sabtu, minggu]
    }

    // ================================================================
    // AKTIVITAS TERAKHIR
    // Untuk timeline di dashboard
    // ================================================================

    public function getAktivitasTerakhir(int $limit = 5)
    {
        return VerifikasiLog::with(['admin', 'pendaftaran.siswa'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    // ================================================================
    // PENDAFTAR TERBARU
    // 10 pendaftar terakhir untuk tabel di dashboard
    // ================================================================

    public function getPendaftaranTerbaru(int $limit = 10)
    {
        return Pendaftaran::with(['siswa', 'sekolahAsal', 'jurusan', 'user'])
            ->latest('tanggal_daftar')
            ->limit($limit)
            ->get();
    }
}