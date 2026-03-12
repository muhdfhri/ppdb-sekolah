<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PendaftaranService;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class PendaftarController extends Controller
{
    public function __construct(
        private PendaftaranService $pendaftaranService
    ) {
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'jurusan_id']);
        $pendaftaran = $this->pendaftaranService->buildQuery($filters)->paginate(15);
        $stats = $this->pendaftaranService->getStats();
        $jurusan = Jurusan::all();

        return view('admin.pendaftar.index', compact('pendaftaran', 'stats', 'jurusan'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with([
            'user',
            'siswa',
            'sekolahAsal',
            'orangTua',
            'jurusan',
            'jurusanPilihan2',
            'dokumen',
            'pembayaran',
            'verifikasiLog.admin',
        ])->findOrFail($id);

        return view('admin.pendaftar.show', compact('pendaftaran'));
    }

    public function terima(Request $request, $id)
    {
        $request->validate(['catatan' => 'nullable|string']);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $this->pendaftaranService->terima($pendaftaran, $request->catatan);

        return redirect()->route('admin.pendaftar.show', $id)
            ->with('success', 'Pendaftaran berhasil diterima.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate(['catatan' => 'required|string|max:500']);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $this->pendaftaranService->tolak($pendaftaran, $request->catatan);

        return redirect()->route('admin.pendaftar.show', $id)
            ->with('success', 'Pendaftaran ditolak.');
    }

    public function verifikasi(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $this->pendaftaranService->verifikasi($pendaftaran);

        return redirect()->route('admin.pendaftar.show', $id)
            ->with('success', 'Berkas terverifikasi.');
    }
}