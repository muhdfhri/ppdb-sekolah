<?php

namespace App\Services\Admin;

use App\Models\Pendaftaran;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;

class LaporanService
{
    // ================================================================
    // STATS RINGKASAN
    // Dipanggil dari Admin\LaporanController::index()
    // ================================================================

    public function getStats(): array
    {
        return [
            'total' => Pendaftaran::count(),
            'diterima' => Pendaftaran::where('status', 'diterima')->count(),
            'ditolak' => Pendaftaran::where('status', 'ditolak')->count(),
            'menunggu' => Pendaftaran::where('status', 'menunggu_verifikasi')->count(),
            'draft' => Pendaftaran::where('status', 'draft')->count(),
        ];
    }

    // ================================================================
    // REKAP PER JURUSAN
    // Dipanggil dari Admin\LaporanController::index()
    // ================================================================

    public function getRekapPerJurusan(): array
    {
        $jurusanList = Jurusan::all();
        $result = [];

        foreach ($jurusanList as $jurusan) {
            // Satu query group by status agar lebih efisien
            $statusCounts = Pendaftaran::where('jurusan_id', $jurusan->id)
                ->select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();

            $result[] = [
                'kode' => $jurusan->kode_jurusan,
                'nama' => $jurusan->nama_jurusan,
                'kuota' => $jurusan->kuota,
                'total' => array_sum($statusCounts),
                'diterima' => $statusCounts['diterima'] ?? 0,
                'menunggu' => $statusCounts['menunggu_verifikasi'] ?? 0,
                'ditolak' => $statusCounts['ditolak'] ?? 0,
                'draft' => $statusCounts['draft'] ?? 0,
                'sisa_kuota' => $jurusan->kuota - ($statusCounts['diterima'] ?? 0),
            ];
        }

        return $result;
    }

    // ================================================================
    // QUERY BUILDER UNTUK TABEL LAPORAN
    // Dengan filter status, support paginate
    // ================================================================

    public function buildQuery(array $filters = [])
    {
        $query = Pendaftaran::with(['siswa', 'sekolahAsal', 'jurusan', 'user']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['jurusan_id'])) {
            $query->where('jurusan_id', $filters['jurusan_id']);
        }

        if (!empty($filters['tanggal_dari'])) {
            $query->whereDate('tanggal_daftar', '>=', $filters['tanggal_dari']);
        }

        if (!empty($filters['tanggal_sampai'])) {
            $query->whereDate('tanggal_daftar', '<=', $filters['tanggal_sampai']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    // ================================================================
    // DATA EXPORT
    // Kembalikan collection flat yang siap diproses Excel/PDF
    // Dipanggil dari Admin\LaporanController::export()
    // ================================================================

    public function getDataExport(array $filters = []): \Illuminate\Support\Collection
    {
        return $this->buildQuery($filters)
            ->get()
            ->map(function ($p, $i) {
                return [
                    'no' => $i + 1,
                    'nomor_pendaftaran' => $p->nomor_pendaftaran,
                    'nama_siswa' => $p->siswa->nama_lengkap ?? $p->user->nama_lengkap,
                    'nik' => $p->siswa->nik ?? '—',
                    'nisn' => $p->sekolahAsal->nisn ?? '—',
                    'tempat_lahir' => $p->siswa->tempat_lahir ?? '—',
                    'tanggal_lahir' => $p->siswa?->tanggal_lahir?->format('d/m/Y') ?? '—',
                    'jenis_kelamin' => $p->siswa->jenis_kelamin ?? '—',
                    'asal_sekolah' => $p->sekolahAsal->nama_sekolah ?? '—',
                    'tahun_lulus' => $p->sekolahAsal->tahun_lulus ?? '—',
                    'nilai_rata_rata' => $p->sekolahAsal->nilai_rata_rata ?? '—',
                    'jurusan_pilihan1' => $p->jurusan->kode_jurusan ?? '—',
                    'jurusan_pilihan2' => $p->jurusanPilihan2?->kode_jurusan ?? '—',
                    'status' => ucfirst(str_replace('_', ' ', $p->status)),
                    'tanggal_daftar' => $p->tanggal_daftar->format('d/m/Y H:i'),
                    'catatan_admin' => $p->catatan_admin ?? '—',
                ];
            });
    }

    // ================================================================
    // STATISTIK BULANAN
    // Untuk grafik tren per bulan (12 bulan terakhir)
    // ================================================================

    public function getStatsBulanan(): array
    {
        $data = Pendaftaran::select(
            DB::raw('MONTH(tanggal_daftar) as bulan'),
            DB::raw('YEAR(tanggal_daftar) as tahun'),
            DB::raw('COUNT(*) as total')
        )
            ->where('tanggal_daftar', '>=', now()->subMonths(12))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        return $data->map(fn($row) => [
            'label' => \Carbon\Carbon::create($row->tahun, $row->bulan)->translatedFormat('M Y'),
            'total' => $row->total,
        ])->toArray();
    }
}