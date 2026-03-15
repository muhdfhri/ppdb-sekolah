<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\PengaturanPpdb;
use App\Services\Siswa\PendaftaranService;
use App\Services\Siswa\DokumenService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function __construct(
        private PendaftaranService $pendaftaranService,
        private DokumenService $dokumenService,
    ) {
    }

    /**
     * Cek apakah user bisa mengakses step tertentu
     */
    private function canAccessStep($pendaftaran, int $targetStep): bool
    {
        $currentStep = $pendaftaran->step_terakhir;

        // Bisa akses step yang sudah pernah dicapai (currentStep) atau sebelumnya
        // Tidak bisa akses step yang lebih besar dari currentStep + 1
        return $targetStep <= $currentStep + 1;
    }

    /**
     * Cek apakah step sebelumnya sudah lengkap
     */
    private function isStepComplete($pendaftaran, int $step): bool
    {
        switch ($step) {
            case 1:
                return $pendaftaran->siswa !== null;
            case 2:
                return $pendaftaran->sekolahAsal !== null;
            case 3:
                return $pendaftaran->orangTua()->count() >= 2; // Minimal ada ayah dan ibu
            case 4:
                return $pendaftaran->jurusan_id !== null;
            case 5:
                return $pendaftaran->dokumen()->count() >= 5; // Minimal dokumen wajib
            default:
                return false;
        }
    }

    /**
     * Redirect ke step yang benar jika akses tidak sah
     */
    private function redirectToCorrectStep($pendaftaran)
    {
        // Cari step pertama yang belum lengkap
        for ($step = 1; $step <= 5; $step++) {
            if (!$this->isStepComplete($pendaftaran, $step)) {
                return redirect()->route('siswa.pendaftaran.step' . $step)
                    ->with('info', 'Silakan lengkapi step ' . $step . ' terlebih dahulu.');
            }
        }

        // Jika semua step sudah lengkap, arahkan ke riwayat
        return redirect()->route('siswa.pendaftaran.riwayat');
    }

    // ── Index ────────────────────────────────────────────────

    public function index(): View
    {
        $user = Auth::user();

        $periodeTersedia = $this->pendaftaranService->getAllPeriodeAktif();
        $periodeGrouped = $this->pendaftaranService->getPeriodeByStatus();

        if ($this->pendaftaranService->hasPendaftaran($user)) {
            $pendaftaran = $user->pendaftaranAktif;
            $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);
            $currentStep = $pendaftaran->step_terakhir;

            return view('siswa.pendaftaran.index', compact(
                'pendaftaran',
                'periodeInfo',
                'currentStep',
                'periodeTersedia',
                'periodeGrouped'
            ));
        }

        return view('siswa.pendaftaran.index', compact('periodeTersedia', 'periodeGrouped'));
    }

    // ── Pilih Periode ────────────────────────────────────────

    public function pilihPeriode(Request $request): RedirectResponse
    {
        $request->validate(['periode_id' => 'required|exists:pengaturan_ppdb,id']);

        $periode = PengaturanPpdb::findOrFail($request->periode_id);

        if (!$periode->isBuka()) {
            return back()->with('error', 'Periode yang dipilih sudah tutup.');
        }

        $this->pendaftaranService->setSelectedPeriode($periode->id);

        return redirect()->route('siswa.pendaftaran.step1')
            ->with('success', 'Silakan lengkapi data pendaftaran untuk periode ' . $periode->tahun_ajaran . '.');
    }

    // ── Step 1: Data Pribadi ─────────────────────────────────

    public function step1(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$this->pendaftaranService->hasPendaftaran($user)) {
            $selectedPeriode = $this->pendaftaranService->getSelectedPeriode();

            if (!$selectedPeriode) {
                return redirect()->route('siswa.pendaftaran.index')
                    ->with('error', 'Silakan pilih periode pendaftaran terlebih dahulu.');
            }
        }

        $pendaftaran = $this->pendaftaranService->getOrCreate(
            $user,
            $this->pendaftaranService->getSelectedPeriode()?->id
        );

        // Cek apakah bisa akses step 1 (selalu bisa)
        if (!$this->canAccessStep($pendaftaran, 1)) {
            return $this->redirectToCorrectStep($pendaftaran);
        }

        $siswa = $pendaftaran->siswa;
        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

        return view('siswa.pendaftaran.step1', compact('pendaftaran', 'siswa', 'periodeInfo'));
    }

    public function step1Store(Request $request): RedirectResponse
    {
        $request->validate([
            // ── Wajib ─────────────────────────────────────────
            'nik' => ['required', 'digits:16'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'agama' => ['required', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu'],
            'alamat_lengkap' => ['required', 'string', 'min:10'],
            // ── Opsional ──────────────────────────────────────
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit angka.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'agama.required' => 'Agama wajib dipilih.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'alamat_lengkap.min' => 'Alamat terlalu singkat, minimal 10 karakter.',
        ]);

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
        $this->pendaftaranService->simpanStep1($pendaftaran, $request->all());

        return redirect()->route('siswa.pendaftaran.step2')
            ->with('success', 'Data pribadi berhasil disimpan.');
    }

    // ── Step 2: Sekolah Asal ─────────────────────────────────

    public function step2(): View|RedirectResponse
    {
        $this->cekPendaftaran();

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());

        // Cek apakah step 1 sudah lengkap
        if (!$this->isStepComplete($pendaftaran, 1)) {
            return redirect()->route('siswa.pendaftaran.step1')
                ->with('error', 'Silakan lengkapi data pribadi terlebih dahulu.');
        }

        // Cek apakah bisa akses step 2
        if (!$this->canAccessStep($pendaftaran, 2)) {
            return $this->redirectToCorrectStep($pendaftaran);
        }

        $sekolah = $pendaftaran->sekolahAsal;
        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

        return view('siswa.pendaftaran.step2', compact('pendaftaran', 'sekolah', 'periodeInfo'));
    }

    public function step2Store(Request $request): RedirectResponse
    {
        $request->validate([
            // ── Wajib ─────────────────────────────────────────
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'alamat_sekolah' => ['required', 'string', 'min:5'],
            'tahun_lulus' => ['required', 'integer', 'min:2000', 'max:' . date('Y')],
            // ── Opsional ──────────────────────────────────────
            'nisn' => ['nullable', 'string', 'max:20'],
            'nilai_rata_rata' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ], [
            'nama_sekolah.required' => 'Nama sekolah asal wajib diisi.',
            'alamat_sekolah.required' => 'Alamat sekolah wajib diisi.',
            'alamat_sekolah.min' => 'Alamat sekolah terlalu singkat.',
            'tahun_lulus.required' => 'Tahun lulus wajib diisi.',
            'tahun_lulus.integer' => 'Tahun lulus harus berupa angka.',
            'tahun_lulus.min' => 'Tahun lulus tidak valid.',
            'tahun_lulus.max' => 'Tahun lulus tidak boleh melebihi tahun ini.',
            'nilai_rata_rata.numeric' => 'Nilai rata-rata harus berupa angka.',
            'nilai_rata_rata.min' => 'Nilai tidak boleh kurang dari 0.',
            'nilai_rata_rata.max' => 'Nilai tidak boleh lebih dari 100.',
        ]);

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
        $this->pendaftaranService->simpanStep2($pendaftaran, $request->all());

        return redirect()->route('siswa.pendaftaran.step3')
            ->with('success', 'Data sekolah asal berhasil disimpan.');
    }

    // ── Step 3: Data Orang Tua ───────────────────────────────

    public function step3(): View|RedirectResponse
    {
        $this->cekPendaftaran();

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());

        // Cek apakah step 2 sudah lengkap
        if (!$this->isStepComplete($pendaftaran, 2)) {
            return redirect()->route('siswa.pendaftaran.step2')
                ->with('error', 'Silakan lengkapi data sekolah asal terlebih dahulu.');
        }

        // Cek apakah bisa akses step 3
        if (!$this->canAccessStep($pendaftaran, 3)) {
            return $this->redirectToCorrectStep($pendaftaran);
        }

        $ayah = $pendaftaran->orangTua()->where('jenis', 'ayah')->first();
        $ibu = $pendaftaran->orangTua()->where('jenis', 'ibu')->first();
        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

        return view('siswa.pendaftaran.step3', compact('pendaftaran', 'ayah', 'ibu', 'periodeInfo'));
    }

    public function step3Store(Request $request): RedirectResponse
    {
        $request->validate([
            // ── Ayah — Wajib ──────────────────────────────────
            'nama_ayah' => ['required', 'string', 'max:255'],
            'tempat_lahir_ayah' => ['required', 'string', 'max:100'],
            'tanggal_lahir_ayah' => ['required', 'date', 'before:today'],
            'pekerjaan_ayah' => ['required', 'string', 'max:255'],
            'penghasilan_ayah' => ['required', 'in:kurang_1jt,1jt_3jt,3jt_5jt,5jt_10jt,lebih_10jt'],
            'telp_ayah' => ['required', 'string', 'max:20'],
            // ── Ayah — Opsional ───────────────────────────────
            'nik_ayah' => ['nullable', 'digits:16'],
            'alamat_ayah' => ['nullable', 'string'],

            // ── Ibu — Wajib ───────────────────────────────────
            'nama_ibu' => ['required', 'string', 'max:255'],
            'tempat_lahir_ibu' => ['required', 'string', 'max:100'],
            'tanggal_lahir_ibu' => ['required', 'date', 'before:today'],
            'pekerjaan_ibu' => ['required', 'string', 'max:255'],
            // ── Ibu — Opsional ────────────────────────────────
            'nik_ibu' => ['nullable', 'digits:16'],
            'telp_ibu' => ['nullable', 'string', 'max:20'],
            'alamat_ibu' => ['nullable', 'string'],
        ], [
            // Ayah
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'tempat_lahir_ayah.required' => 'Tempat lahir ayah wajib diisi.',
            'tanggal_lahir_ayah.required' => 'Tanggal lahir ayah wajib diisi.',
            'tanggal_lahir_ayah.before' => 'Tanggal lahir ayah tidak valid.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi.',
            'penghasilan_ayah.required' => 'Penghasilan ayah wajib dipilih.',
            'penghasilan_ayah.in' => 'Pilihan penghasilan ayah tidak valid.',
            'telp_ayah.required' => 'No. telepon ayah wajib diisi.',
            'nik_ayah.digits' => 'NIK ayah harus 16 digit.',
            // Ibu
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'tempat_lahir_ibu.required' => 'Tempat lahir ibu wajib diisi.',
            'tanggal_lahir_ibu.required' => 'Tanggal lahir ibu wajib diisi.',
            'tanggal_lahir_ibu.before' => 'Tanggal lahir ibu tidak valid.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib diisi.',
            'nik_ibu.digits' => 'NIK ibu harus 16 digit.',
        ]);

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());

        $ayah = [
            'nama_lengkap' => $request->nama_ayah,
            'nik' => $request->nik_ayah,
            'tempat_lahir' => $request->tempat_lahir_ayah,
            'tanggal_lahir' => $request->tanggal_lahir_ayah,
            'no_telepon' => $request->telp_ayah,
            'pekerjaan' => $request->pekerjaan_ayah,
            'penghasilan' => $request->penghasilan_ayah,
            'alamat' => $request->alamat_ayah,
        ];

        $ibu = [
            'nama_lengkap' => $request->nama_ibu,
            'nik' => $request->nik_ibu,
            'tempat_lahir' => $request->tempat_lahir_ibu,
            'tanggal_lahir' => $request->tanggal_lahir_ibu,
            'no_telepon' => $request->telp_ibu,
            'pekerjaan' => $request->pekerjaan_ibu,
            'alamat' => $request->alamat_ibu,
        ];

        $this->pendaftaranService->simpanStep3($pendaftaran, $ayah, $ibu);

        return redirect()->route('siswa.pendaftaran.step4')
            ->with('success', 'Data orang tua berhasil disimpan.');
    }

    // ── Step 4: Pilih Jurusan ────────────────────────────────

    public function step4(): View|RedirectResponse
    {
        $this->cekPendaftaran();

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());

        // Cek apakah step 3 sudah lengkap
        if (!$this->isStepComplete($pendaftaran, 3)) {
            return redirect()->route('siswa.pendaftaran.step3')
                ->with('error', 'Silakan lengkapi data orang tua terlebih dahulu.');
        }

        // Cek apakah bisa akses step 4
        if (!$this->canAccessStep($pendaftaran, 4)) {
            return $this->redirectToCorrectStep($pendaftaran);
        }

        $jurusan = Jurusan::aktif()->get();
        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

        return view('siswa.pendaftaran.step4', compact('pendaftaran', 'jurusan', 'periodeInfo'));
    }

    public function step4Store(Request $request): RedirectResponse
    {
        $request->validate([
            // ── Wajib ─────────────────────────────────────────
            'jurusan_id' => ['required', 'exists:jurusan,id'],
        ], [
            'jurusan_id.required' => 'Pilihan jurusan utama wajib dipilih.',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
        ]);

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
        $this->pendaftaranService->simpanStep4($pendaftaran, $request->only('jurusan_id'));

        return redirect()->route('siswa.pendaftaran.step5')
            ->with('success', 'Pilihan jurusan berhasil disimpan.');
    }

    // ── Step 5: Upload Dokumen ───────────────────────────────

    public function step5(): View|RedirectResponse
    {
        $this->cekPendaftaran();

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());

        // Cek apakah step 4 sudah lengkap
        if (!$this->isStepComplete($pendaftaran, 4)) {
            return redirect()->route('siswa.pendaftaran.step4')
                ->with('error', 'Silakan pilih jurusan terlebih dahulu.');
        }

        // Cek apakah bisa akses step 5
        if (!$this->canAccessStep($pendaftaran, 5)) {
            return $this->redirectToCorrectStep($pendaftaran);
        }

        $dokumen = $pendaftaran->dokumen->keyBy('jenis_dokumen');
        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

        return view('siswa.pendaftaran.step5', compact('pendaftaran', 'dokumen', 'periodeInfo'));
    }

    public function step5Store(Request $request): RedirectResponse
    {
        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
        $dokumenAda = $pendaftaran->dokumen->keyBy('jenis_dokumen');

        // Dokumen wajib hanya required jika BELUM pernah diupload
        $request->validate([
            'ijazah' => [$dokumenAda->has('ijazah') ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'kartu_keluarga' => [$dokumenAda->has('kartu_keluarga') ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'akte_kelahiran' => [$dokumenAda->has('akte_kelahiran') ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'pas_foto' => [$dokumenAda->has('pas_foto') ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'bukti_pembayaran' => [$dokumenAda->has('bukti_pembayaran') ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'kip' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'ijazah.required' => 'File ijazah/SKL wajib diupload.',
            'kartu_keluarga.required' => 'File Kartu Keluarga wajib diupload.',
            'akte_kelahiran.required' => 'File Akta Kelahiran wajib diupload.',
            'pas_foto.required' => 'Pas foto wajib diupload.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.',
            '*.mimes' => 'Format file tidak didukung. Gunakan PDF, JPG, atau PNG.',
            '*.max' => 'Ukuran file maksimal 2MB.',
            'pas_foto.mimes' => 'Pas foto harus format JPG atau PNG.',
        ]);

        $jenisDokumen = ['ijazah', 'kartu_keluarga', 'akte_kelahiran', 'pas_foto', 'bukti_pembayaran', 'kip'];

        foreach ($jenisDokumen as $jenis) {
            if ($request->hasFile($jenis)) {
                $this->dokumenService->simpan($pendaftaran, $jenis, $request->file($jenis));
            }
        }

        $this->pendaftaranService->finalisasi($pendaftaran);

        return redirect()->route('siswa.pendaftaran.riwayat')
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu verifikasi dari panitia.');
    }

    // ── Riwayat Pendaftaran ──────────────────────────────────
    public function riwayat(): \Illuminate\View\View
    {
        $user = Auth::user();
        $pendaftaran = $user->pendaftaranAktif;

        // Jika tidak ada pendaftaran aktif, cek pendaftaran lain (ditolak/diterima)
        if (!$pendaftaran) {
            $pendaftaran = \App\Models\Pendaftaran::where('user_id', $user->id)
                ->latest()
                ->first();
        }

        // Jika benar-benar kosong, tetap render view dengan pendaftaran null
        if (!$pendaftaran) {
            return view('siswa.pendaftaran.riwayat', ['pendaftaran' => null, 'periodeInfo' => null]);
        }

        $pendaftaran->load([
            'siswa',
            'sekolahAsal',
            'orangTua',
            'jurusan',
            'jurusanPilihan2',
            'dokumen',
            'pengaturanPpdb',
            'verifikasiLog.admin',
        ]);

        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

        return view('siswa.pendaftaran.riwayat', compact('pendaftaran', 'periodeInfo'));
    }

    // ── Cetak Bukti ──────────────────────────────────────────

    public function cetak(): \Illuminate\Http\Response
    {
        $pendaftaran = Auth::user()->pendaftaranAktif;

        abort_if(!$pendaftaran, 404, 'Data pendaftaran tidak ditemukan.');

        $pendaftaran->load([
            'siswa',
            'sekolahAsal',
            'orangTua',
            'jurusan',
            'jurusanPilihan2',
            'dokumen',
            'pengaturanPpdb',
        ]);

        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

        // Tampilkan preview di browser (template sama dengan PDF)
        return response(
            view('siswa.pendaftaran.cetak-pdf', compact('pendaftaran', 'periodeInfo'))->render()
        )->header('Content-Type', 'text/html');
    }

    /**
     * Download bukti pendaftaran sebagai PDF.
     * GET /siswa/pendaftaran/cetak/pdf
     */
    public function cetakPdf(): \Illuminate\Http\Response
    {
        $pendaftaran = Auth::user()->pendaftaranAktif;

        abort_if(!$pendaftaran, 404, 'Data pendaftaran tidak ditemukan.');

        $pendaftaran->load([
            'siswa',
            'sekolahAsal',
            'orangTua',
            'jurusan',
            'jurusanPilihan2',
            'dokumen',
            'pengaturanPpdb',
        ]);

        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

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

    // ── Private ──────────────────────────────────────────────

    private function cekPendaftaran(): void
    {
        if (!$this->pendaftaranService->hasPendaftaran(Auth::user())) {
            abort(404, 'Data pendaftaran tidak ditemukan.');
        }
    }
}