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

    // ── Index ────────────────────────────────────────────────

    public function index(): View
    {
        $user = Auth::user();

        if ($this->pendaftaranService->hasPendaftaran($user)) {
            $pendaftaran = $user->pendaftaranAktif;
            $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);
            $currentStep = $pendaftaran->step_terakhir;

            return view('siswa.pendaftaran.index', compact('pendaftaran', 'periodeInfo', 'currentStep'));
        }

        $periodeTersedia = $this->pendaftaranService->getAllPeriodeAktif();
        $periodeGrouped = $this->pendaftaranService->getPeriodeByStatus();

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

    public function step1()
    {
        $user = Auth::user();

        // CEK APAKAH USER SUDAH PUNYA PENDAFTARAN
        if ($this->pendaftaranService->hasPendaftaran($user)) {
            $pendaftaran = $this->pendaftaranService->getOrCreate($user);
            $siswa = $pendaftaran->siswa;
            $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);
            return view('siswa.pendaftaran.step1', compact('pendaftaran', 'siswa', 'periodeInfo'));
        }

        // JIKA BELUM PUNYA PENDAFTARAN, CEK APAKAH SUDAH PILIH PERIODE
        $selectedPeriode = $this->pendaftaranService->getSelectedPeriode();

        if (!$selectedPeriode) {
            return redirect()->route('siswa.pendaftaran.index')
                ->with('error', 'Silakan pilih periode pendaftaran terlebih dahulu.');
        }

        // BUAT PENDAFTARAN BARU DENGAN PERIODE YANG DIPILIH
        $pendaftaran = $this->pendaftaranService->getOrCreate($user, $selectedPeriode->id);
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

    public function step2(): View
    {
        $this->cekPendaftaran();

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
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
        ]);

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
        $this->pendaftaranService->simpanStep2($pendaftaran, $request->all());

        return redirect()->route('siswa.pendaftaran.step3')
            ->with('success', 'Data sekolah asal berhasil disimpan.');
    }

    // ── Step 3: Data Orang Tua ───────────────────────────────

    public function step3(): View
    {
        $this->cekPendaftaran();

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
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

    public function step4(): View
    {
        $this->cekPendaftaran();

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
        $jurusan = Jurusan::aktif()->get();
        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

        return view('siswa.pendaftaran.step4', compact('pendaftaran', 'jurusan', 'periodeInfo'));
    }

    public function step4Store(Request $request): RedirectResponse
    {
        $request->validate([
            // ── Wajib ─────────────────────────────────────────
            'jurusan_id' => ['required', 'exists:jurusan,id'],
            // ── Opsional ──────────────────────────────────────
            'jurusan_id_2' => ['nullable', 'exists:jurusan,id', 'different:jurusan_id'],
        ]);

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
        $this->pendaftaranService->simpanStep4($pendaftaran, $request->only('jurusan_id', 'jurusan_id_2'));

        return redirect()->route('siswa.pendaftaran.step5')
            ->with('success', 'Pilihan jurusan berhasil disimpan.');
    }

    // ── Step 5: Upload Dokumen ───────────────────────────────

    public function step5(): View
    {
        $this->cekPendaftaran();

        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
        $dokumen = $pendaftaran->dokumen->keyBy('jenis_dokumen');
        $periodeInfo = $this->pendaftaranService->getPeriodeInfo($pendaftaran);

        return view('siswa.pendaftaran.step5', compact('pendaftaran', 'dokumen', 'periodeInfo'));
    }

    public function step5Store(Request $request): RedirectResponse
    {
        $pendaftaran = $this->pendaftaranService->getOrCreate(Auth::user());
        $dokumenAda = $pendaftaran->dokumen->keyBy('jenis_dokumen');

        $request->validate([
            'ijazah' => [$dokumenAda->has('ijazah') ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'kartu_keluarga' => [$dokumenAda->has('kartu_keluarga') ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'akte_kelahiran' => [$dokumenAda->has('akte_kelahiran') ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'pas_foto' => [$dokumenAda->has('pas_foto') ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'bukti_pembayaran' => [$dokumenAda->has('bukti_pembayaran') ? 'nullable' : 'required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'kip' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $jenisDokumen = ['ijazah', 'kartu_keluarga', 'akte_kelahiran', 'pas_foto', 'bukti_pembayaran', 'kip'];

        foreach ($jenisDokumen as $jenis) {
            if ($request->hasFile($jenis)) {
                $this->dokumenService->simpan($pendaftaran, $jenis, $request->file($jenis));
            }
        }

        $this->pendaftaranService->finalisasi($pendaftaran);

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu verifikasi dari panitia.');
    }

    // ── Cetak Bukti ──────────────────────────────────────────

    public function cetak(): View
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

        return view('siswa.pendaftaran.cetak', compact('pendaftaran', 'periodeInfo'));
    }

    // ── Private ──────────────────────────────────────────────

    private function cekPendaftaran(): void
    {
        if (!$this->pendaftaranService->hasPendaftaran(Auth::user())) {
            abort(404, 'Data pendaftaran tidak ditemukan.');
        }
    }
}