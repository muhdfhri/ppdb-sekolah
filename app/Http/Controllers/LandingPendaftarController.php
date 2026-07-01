<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\SekolahAsal;
use App\Models\OrangTua;
use App\Models\Jurusan;
use App\Models\PengaturanPpdb;
use App\Services\Siswa\DokumenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LandingPendaftarController extends Controller
{
    public function __construct(
        private DokumenService $dokumenService
    ) {}

    public function showForm()
    {
        $periode = PengaturanPpdb::aktif()
            ->where('tanggal_buka', '<=', now())
            ->where('tanggal_tutup', '>=', now())
            ->first();

        if (!$periode) {
            return redirect()->route('home')->with('error', 'Mohon maaf, tidak ada periode pendaftaran aktif saat ini.');
        }

        $jurusan = Jurusan::aktif()->get();

        return view('landing.pendaftar', compact('periode', 'jurusan'));
    }

    public function store(Request $request)
    {
        $periode = PengaturanPpdb::aktif()
            ->where('tanggal_buka', '<=', now())
            ->where('tanggal_tutup', '>=', now())
            ->first();

        if (!$periode) {
            return redirect()->route('home')->with('error', 'Periode pendaftaran sudah ditutup.');
        }

        $request->validate([
            // Step 1: Biodata Pendaftar
            // Data Pribadi
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'alamat_lengkap' => 'required|string|min:10',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',

            // Sekolah Asal
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|min:5',
            'tahun_lulus' => 'required|integer|min:2000|max:' . date('Y'),
            'nisn' => 'required|string|max:20',
            'nilai_rata_rata' => 'required|numeric|min:0|max:100',

            // Orang Tua (Ayah)
            'nama_ayah' => 'required|string|max:255',
            'tempat_lahir_ayah' => 'required|string|max:100',
            'tanggal_lahir_ayah' => 'required|date|before:today',
            'pekerjaan_ayah' => 'required|string|max:255',
            'penghasilan_ayah' => 'required|in:kurang_1jt,1jt_3jt,3jt_5jt,5jt_10jt,lebih_10jt',
            'telp_ayah' => 'required|string|max:20',
            'nik_ayah' => 'required|digits:16',
            'alamat_ayah' => 'required|string',

            // Orang Tua (Ibu)
            'nama_ibu' => 'required|string|max:255',
            'tempat_lahir_ibu' => 'required|string|max:100',
            'tanggal_lahir_ibu' => 'required|date|before:today',
            'pekerjaan_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|digits:16',
            'telp_ibu' => 'required|string|max:20',
            'alamat_ibu' => 'required|string',

            // Step 2: Akademik
            'jurusan_id' => 'required|exists:jurusan,id',
            'jurusan_id_2' => 'nullable|exists:jurusan,id',

            // Step 3: Berkas
            'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akte_kelahiran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pas_foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'bukti_pembayaran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'agama.required' => 'Agama wajib dipilih.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'nama_sekolah.required' => 'Nama sekolah asal wajib diisi.',
            'alamat_sekolah.required' => 'Alamat sekolah asal wajib diisi.',
            'tahun_lulus.required' => 'Tahun lulus wajib diisi.',
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi.',
            'penghasilan_ayah.required' => 'Penghasilan ayah wajib diisi.',
            'telp_ayah.required' => 'No. telepon ayah wajib diisi.',
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib diisi.',
            'jurusan_id.required' => 'Pilihan jurusan utama wajib diisi.',
            'ijazah.required' => 'File ijazah/SKL wajib diupload.',
            'kartu_keluarga.required' => 'File Kartu Keluarga wajib diupload.',
            'akte_kelahiran.required' => 'File Akta Kelahiran wajib diupload.',
            'pas_foto.required' => 'Pas foto wajib diupload.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.',
            'alamat_lengkap.min' => 'Alamat lengkap minimal harus 10 karakter.',
            'alamat_sekolah.min' => 'Alamat sekolah asal minimal harus 5 karakter.',
            'nik_ayah.digits' => 'NIK ayah harus 16 digit.',
            'nik_ibu.digits' => 'NIK ibu harus 16 digit.',
            '*.mimes' => 'Format file tidak didukung. Gunakan PDF, JPG, atau PNG.',
            '*.max' => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create Pendaftaran
            $nomorPendaftaran = Pendaftaran::generateNomor(date('Y'));
            $pendaftaran = Pendaftaran::create([
                'nama_lengkap' => $request->nama_lengkap,
                'pengaturan_ppdb_id' => $periode->id,
                'jurusan_id' => $request->jurusan_id,
                'jurusan_id_2' => $request->jurusan_id_2,
                'nomor_pendaftaran' => $nomorPendaftaran,
                'tanggal_daftar' => now(),
                'status' => 'menunggu_verifikasi',
                'step_terakhir' => 3,
            ]);

            // 2. Create Siswa
            Siswa::create([
                'pendaftaran_id' => $pendaftaran->id,
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat_lengkap' => $request->alamat_lengkap,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
            ]);

            // 3. Create Sekolah Asal
            SekolahAsal::create([
                'pendaftaran_id' => $pendaftaran->id,
                'nama_sekolah' => $request->nama_sekolah,
                'alamat_sekolah' => $request->alamat_sekolah,
                'tahun_lulus' => $request->tahun_lulus,
                'nisn' => $request->nisn,
                'nilai_rata_rata' => $request->nilai_rata_rata,
            ]);

            // 4. Create Orang Tua (Ayah)
            OrangTua::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jenis' => 'ayah',
                'nama_lengkap' => $request->nama_ayah,
                'nik' => $request->nik_ayah,
                'tempat_lahir' => $request->tempat_lahir_ayah,
                'tanggal_lahir' => $request->tanggal_lahir_ayah,
                'pekerjaan' => $request->pekerjaan_ayah,
                'penghasilan' => $request->penghasilan_ayah,
                'no_telepon' => $request->telp_ayah,
                'alamat' => $request->alamat_ayah ?: $request->alamat_lengkap,
            ]);

            // 5. Create Orang Tua (Ibu)
            OrangTua::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jenis' => 'ibu',
                'nama_lengkap' => $request->nama_ibu,
                'nik' => $request->nik_ibu,
                'tempat_lahir' => $request->tempat_lahir_ibu,
                'tanggal_lahir' => $request->tanggal_lahir_ibu,
                'pekerjaan' => $request->pekerjaan_ibu,
                'no_telepon' => $request->telp_ibu,
                'alamat' => $request->alamat_ibu ?: $request->alamat_lengkap,
            ]);

            // 6. Upload Dokumen
            $jenisDokumen = ['ijazah', 'kartu_keluarga', 'akte_kelahiran', 'pas_foto', 'bukti_pembayaran', 'kip'];
            foreach ($jenisDokumen as $jenis) {
                if ($request->hasFile($jenis)) {
                    $this->dokumenService->simpan($pendaftaran, $jenis, $request->file($jenis));
                }
            }

            DB::commit();

            return redirect()->route('landing.pendaftaran.success', $pendaftaran->id)
                ->with('success', 'Pendaftaran Anda berhasil dikirim! Simpan Nomor Pendaftaran Anda.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal mendaftar: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memproses pendaftaran. Silakan coba beberapa saat lagi.');
        }
    }

    public function success($id)
    {
        $pendaftaran = Pendaftaran::with(['siswa', 'sekolahAsal', 'orangTua', 'jurusan'])->findOrFail($id);

        return view('landing.success', compact('pendaftaran'));
    }

    public function cetakPdf($id)
    {
        $pendaftaran = Pendaftaran::with([
            'siswa',
            'sekolahAsal',
            'orangTua',
            'jurusan',
            'jurusanPilihan2',
            'dokumen',
            'pengaturanPpdb',
        ])->findOrFail($id);

        $periodeInfo = [
            'id' => $pendaftaran->pengaturanPpdb->id,
            'tahun_ajaran' => $pendaftaran->pengaturanPpdb->tahun_ajaran,
            'tanggal_buka' => $pendaftaran->pengaturanPpdb->tanggal_buka,
            'tanggal_tutup' => $pendaftaran->pengaturanPpdb->tanggal_tutup,
            'tanggal_pengumuman' => $pendaftaran->pengaturanPpdb->tanggal_pengumuman,
            'biaya' => $pendaftaran->pengaturanPpdb->biaya_pendaftaran,
            'is_buka' => $pendaftaran->pengaturanPpdb->isBuka(),
            'sisa_hari' => now()->diffInDays($pendaftaran->pengaturanPpdb->tanggal_tutup, false),
            'status' => 'berlangsung',
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'siswa.pendaftaran.cetak-pdf',
            compact('pendaftaran', 'periodeInfo')
        )
            ->setPaper('a4', 'portrait')
            ->setOption([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
            ]);

        $filename = 'Bukti-Pendaftaran-' . $pendaftaran->nomor_pendaftaran . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
