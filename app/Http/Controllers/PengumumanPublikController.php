<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PengumumanPublikController extends Controller
{
    /**
     * Halaman publik dengan 2 tab:
     * - Tab 1: Daftar pengumuman dari admin
     * - Tab 2: Hasil seleksi pendaftaran
     */
    public function index()
    {
        // Tab 1: Pengumuman yang sudah dipublish
        $pengumuman = Pengumuman::published()
            ->with('createdBy')
            ->latest('tanggal_publish')
            ->paginate(10, ['*'], 'page_pengumuman');

        // Tab 2: Hasil seleksi — hanya status yang layak tampil publik
        $pendaftaran = Pendaftaran::with(['siswa', 'sekolahAsal', 'jurusan'])
            ->whereIn('status', ['diterima', 'cadangan', 'ditolak', 'menunggu_verifikasi', 'terverifikasi'])
            ->orderByRaw("FIELD(status, 'diterima', 'cadangan', 'menunggu_verifikasi', 'terverifikasi', 'ditolak')")
            ->orderBy('nomor_pendaftaran')
            ->paginate(20, ['*'], 'page_seleksi');

        return view('pengumuman.publik', compact('pengumuman', 'pendaftaran'));
    }

    /**
     * Halaman detail satu pengumuman.
     */
    public function show($id)
    {
        $pengumuman = Pengumuman::published()
            ->with('createdBy')
            ->findOrFail($id);

        return view('pengumuman.publik-show', compact('pengumuman'));
    }
}