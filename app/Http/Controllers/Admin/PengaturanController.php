<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\JurusanService;
use App\Models\PengaturanPpdb;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function __construct(
        private JurusanService $jurusanService
    ) {
    }

    /**
     * Menampilkan daftar periode PPDB
     */
    public function index()
    {
        // Ambil semua periode untuk ditampilkan di tabel
        $periode = PengaturanPpdb::orderBy('created_at', 'desc')->paginate(10);

        // Ambil periode aktif (hanya 1 yang sedang aktif/berjalan)
        $ppdb = PengaturanPpdb::where('is_active', true)->first();

        $jurusan = Jurusan::all();

        return view('admin.pengaturan.index', compact('periode', 'ppdb', 'jurusan'));
    }

    /**
     * Menampilkan form tambah periode
     */
    public function createPeriode()
    {
        return view('admin.pengaturan.create');
    }

    /**
     * Menyimpan periode baru
     */
    public function storePeriode(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after:tanggal_buka',
            'tanggal_pengumuman' => 'nullable|date',
            'biaya_pendaftaran' => 'nullable|numeric|min:0',
            'tanggal_daftar_ulang_mulai' => 'nullable|date',
            'tanggal_daftar_ulang_selesai' => 'nullable|date|after:tanggal_daftar_ulang_mulai',
        ]);

        // TIDAK ADA LOGIKA UNTUK MENONAKTIFKAN PERIODE LAIN
        // Bisa multiple aktif

        PengaturanPpdb::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'tanggal_buka' => $request->tanggal_buka,
            'tanggal_tutup' => $request->tanggal_tutup,
            'tanggal_pengumuman' => $request->tanggal_pengumuman,
            'biaya_pendaftaran' => $request->biaya_pendaftaran ?? 0,
            'tanggal_daftar_ulang_mulai' => $request->tanggal_daftar_ulang_mulai,
            'tanggal_daftar_ulang_selesai' => $request->tanggal_daftar_ulang_selesai,
            'is_active' => $request->has('is_active'), // Bisa true tanpa menonaktifkan yang lain
        ]);

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Periode PPDB berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail periode
     */
    public function showPeriode($id)
    {
        $ppdb = PengaturanPpdb::findOrFail($id);
        $jurusan = Jurusan::all();

        return view('admin.pengaturan.show', compact('ppdb', 'jurusan'));
    }

    /**
     * Menampilkan form edit periode
     */
    public function editPeriode($id)
    {
        $ppdb = PengaturanPpdb::findOrFail($id);
        $jurusan = Jurusan::all();

        return view('admin.pengaturan.edit', compact('ppdb', 'jurusan'));
    }

    /**
     * Update periode
     */
    public function updatePeriode(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after:tanggal_buka',
            'tanggal_pengumuman' => 'nullable|date',
            'biaya_pendaftaran' => 'nullable|numeric|min:0',
            'tanggal_daftar_ulang_mulai' => 'nullable|date',
            'tanggal_daftar_ulang_selesai' => 'nullable|date|after:tanggal_daftar_ulang_mulai',
        ]);

        $ppdb = PengaturanPpdb::findOrFail($id);

        // TIDAK MENONAKTIFKAN PERIODE LAIN
        $ppdb->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'tanggal_buka' => $request->tanggal_buka,
            'tanggal_tutup' => $request->tanggal_tutup,
            'tanggal_pengumuman' => $request->tanggal_pengumuman,
            'biaya_pendaftaran' => $request->biaya_pendaftaran ?? 0,
            'tanggal_daftar_ulang_mulai' => $request->tanggal_daftar_ulang_mulai,
            'tanggal_daftar_ulang_selesai' => $request->tanggal_daftar_ulang_selesai,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Periode PPDB berhasil diperbarui.');
    }

    /**
     * Hapus periode
     */
    public function destroyPeriode($id)
    {
        $ppdb = PengaturanPpdb::findOrFail($id);

        // Cek apakah ada pendaftaran terkait
        if ($ppdb->pendaftaran()->count() > 0) {
            return redirect()->route('admin.pengaturan.index')
                ->with('error', 'Periode tidak dapat dihapus karena sudah memiliki data pendaftaran.');
        }

        $ppdb->delete();

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Periode PPDB berhasil dihapus.');
    }

    /**
     * Toggle status aktif periode (ON/OFF)
     */
    public function toggleActive($id)
    {
        $ppdb = PengaturanPpdb::findOrFail($id);
        $ppdb->is_active = !$ppdb->is_active;
        $ppdb->save();

        $status = $ppdb->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.pengaturan.index')
            ->with('success', "Periode PPDB berhasil {$status}.");
    }

    /**
     * Update kuota jurusan
     */
    public function updateKuota(Request $request)
    {
        $request->validate([
            'kuota.*' => 'required|numeric|min:0',
        ]);

        foreach ($request->kuota as $id => $kuota) {
            $jurusan = Jurusan::find($id);
            if ($jurusan) {
                $jurusan->kuota = $kuota;
                $jurusan->is_active = isset($request->aktif[$id]);
                $jurusan->save();
            }
        }

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Kuota jurusan berhasil disimpan.');
    }
}