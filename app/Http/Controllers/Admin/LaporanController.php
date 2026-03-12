<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\LaporanService;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LaporanController extends Controller
{
    public function __construct(
        private LaporanService $laporanService
    ) {
    }

    // ── Index ────────────────────────────────────────────────

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'jurusan_id', 'tanggal_dari', 'tanggal_sampai']);
        $pendaftaran = $this->laporanService->buildQuery($filters)->paginate(20);
        $stats = $this->laporanService->getStats();
        $rekapJurusan = $this->laporanService->getRekapPerJurusan();

        return view('admin.laporan', compact('pendaftaran', 'stats', 'rekapJurusan'));
    }

    // ── Export ───────────────────────────────────────────────

    /**
     * Export laporan ke Excel atau PDF.
     * GET /admin/laporan/export/{format}   format: xlsx | pdf
     */
    public function export(Request $request, string $format): BinaryFileResponse
    {
        $filters = $request->only(['status', 'jurusan_id', 'tanggal_dari', 'tanggal_sampai']);
        $data = $this->laporanService->getDataExport($filters);
        $export = new LaporanExport();
        $filename = 'Laporan - PPDB - ' . now()->format('d-m-Y');

        if ($format === 'pdf') {
            $path = $export->toPdf($data);
            return response()->download($path, "{$filename}.pdf", [
                'Content-Type' => 'application/pdf',
            ])->deleteFileAfterSend(true);
        }

        // Default: xlsx
        $path = $export->toExcel($data);
        return response()->download($path, "{$filename}.xlsx", [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}