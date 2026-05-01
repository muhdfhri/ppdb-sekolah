<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PendaftaranService;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $stats = $this->pendaftaranService->getStats(); // Pastikan ini mengembalikan array yang benar
        $jurusan = Jurusan::all();

        // Debug: Cek isi stats (hapus setelah memastikan berfungsi)
        // dd($stats);

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

    /**
     * Hapus data pendaftaran beserta semua data terkait
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $pendaftaran = Pendaftaran::findOrFail($id);

            // Cek apakah bisa dihapus (hanya status menunggu_verifikasi yang bisa dihapus)
            if ($pendaftaran->status !== 'menunggu_verifikasi') {
                return redirect()->route('admin.pendaftar.index')
                    ->with('error', 'Pendaftaran dengan status "' . $this->getStatusLabel($pendaftaran->status) . '" tidak dapat dihapus.');
            }

            $nama = $pendaftaran->siswa->nama_lengkap ?? 'Unknown';
            $nomor = $pendaftaran->nomor_pendaftaran;

            // Hapus data (cascade akan berjalan otomatis)
            $pendaftaran->delete();

            DB::commit();

            return redirect()->route('admin.pendaftar.index')
                ->with('success', "Data pendaftar {$nama} ({$nomor}) berhasil dihapus.");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.pendaftar.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Get status label in Indonesian
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
        ];

        return $labels[$status] ?? $status;
    }
}