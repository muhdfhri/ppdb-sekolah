<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use App\Models\PengaturanPpdb;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {
    }

    public function index()
    {
        $stats = $this->dashboardService->getStats();
        $aktivitas = $this->dashboardService->getAktivitasTerakhir(5);
        $pendaftaranTerbaru = $this->dashboardService->getPendaftaranTerbaru(10);
        $trenMingguan = $this->dashboardService->getTrenMingguan();
        $ppdb = PengaturanPpdb::where('is_active', true)->first();

        return view('admin.dashboard', compact(
            'stats',
            'aktivitas',
            'pendaftaranTerbaru',
            'trenMingguan',
            'ppdb'
        ));
    }
}