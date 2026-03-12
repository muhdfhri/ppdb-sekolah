<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Services\Siswa\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {
    }

    public function index(): View
    {
        $data = $this->dashboardService->getSiswaData(Auth::user());

        return view('siswa.dashboard', $data);
    }

    public function profil(): View
    {
        $user = Auth::user();
        $pendaftaran = $user->pendaftaranAktif;
        $siswa = $pendaftaran?->siswa;

        return view('siswa.profil', compact('user', 'pendaftaran', 'siswa'));
    }

    public function pengumuman(): View
    {
        $pengumuman = Pengumuman::published()
            ->latest('tanggal_publish')
            ->paginate(10);

        return view('siswa.pengumuman', compact('pengumuman'));
    }
}