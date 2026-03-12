<?php

namespace App\Services\Siswa;

use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\SekolahAsal;
use App\Models\OrangTua;
use App\Models\PengaturanPpdb;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PendaftaranService
{
    /**
     * Ambil atau buat pendaftaran aktif untuk user
     * Bisa dengan periode tertentu atau periode aktif default
     */
    public function getOrCreate(User $user, ?int $periodeId = null): Pendaftaran
    {
        // Cek apakah user sudah punya pendaftaran aktif (draft atau menunggu)
        $existingPendaftaran = Pendaftaran::where('user_id', $user->id)
            ->whereIn('status', ['draft', 'menunggu_verifikasi', 'terverifikasi'])
            ->first();

        if ($existingPendaftaran) {
            return $existingPendaftaran;
        }

        // Jika tidak ada pendaftaran existing, buat baru dengan periode tertentu
        if ($periodeId) {
            $ppdb = PengaturanPpdb::findOrFail($periodeId);
        } else {
            // Jika periodeId tidak diberikan, gunakan periode aktif yang sedang berlangsung
            $ppdb = PengaturanPpdb::aktif()
                ->where('tanggal_buka', '<=', now())
                ->where('tanggal_tutup', '>=', now())
                ->first();
        }

        // Jika tidak ada periode yang valid, throw exception
        if (!$ppdb) {
            throw new \Exception('Tidak ada periode pendaftaran yang tersedia.');
        }

        // Cek apakah periode masih buka
        if (!$ppdb->isBuka()) {
            throw new \Exception('Periode pendaftaran sudah tutup.');
        }

        // Buat pendaftaran baru
        return Pendaftaran::create([
            'user_id' => $user->id,
            'pengaturan_ppdb_id' => $ppdb->id,
            'nomor_pendaftaran' => Pendaftaran::generateNomor(date('Y')),
            'status' => 'draft',
            'step_terakhir' => 1,
            'tanggal_daftar' => now(),
        ]);
    }

    /**
     * Mendapatkan periode yang dipilih user dari session
     */
    public function getSelectedPeriode(): ?PengaturanPpdb
    {
        $periodeId = Session::get('selected_periode_id');

        if (!$periodeId) {
            return null;
        }

        return PengaturanPpdb::find($periodeId);
    }

    /**
     * Menyimpan periode yang dipilih ke session
     */
    public function setSelectedPeriode(int $periodeId): void
    {
        Session::put('selected_periode_id', $periodeId);
    }

    /**
     * Menghapus session periode
     */
    public function clearSelectedPeriode(): void
    {
        Session::forget('selected_periode_id');
    }

    /**
     * Mendapatkan semua periode aktif (is_active = true)
     * TANPA filter tanggal, untuk ditampilkan di halaman pilihan
     */
    public function getAllPeriodeAktif()
    {
        return PengaturanPpdb::aktif()
            ->orderBy('tanggal_buka', 'desc')
            ->get();
    }

    /**
     * Mendapatkan periode yang sedang berlangsung (untuk pendaftaran)
     * Hanya periode dengan tanggal buka <= sekarang <= tanggal tutup
     */
    public function getPeriodeTersedia()
    {
        return PengaturanPpdb::aktif()
            ->where('tanggal_buka', '<=', now())
            ->where('tanggal_tutup', '>=', now())
            ->orderBy('tanggal_buka', 'asc')
            ->get();
    }

    /**
     * Mendapatkan periode yang akan datang (belum dibuka)
     */
    public function getPeriodeAkanDatang()
    {
        return PengaturanPpdb::aktif()
            ->where('tanggal_buka', '>', now())
            ->orderBy('tanggal_buka', 'asc')
            ->get();
    }

    /**
     * Mendapatkan periode yang sudah berakhir
     */
    public function getPeriodeBerakhir()
    {
        return PengaturanPpdb::aktif()
            ->where('tanggal_tutup', '<', now())
            ->orderBy('tanggal_tutup', 'desc')
            ->get();
    }

    /**
     * Cek apakah user sudah memiliki pendaftaran
     */
    public function hasPendaftaran(User $user): bool
    {
        return Pendaftaran::where('user_id', $user->id)
            ->whereIn('status', ['draft', 'menunggu_verifikasi', 'terverifikasi', 'diterima'])
            ->exists();
    }

    /**
     * Step 1 — Simpan data pribadi siswa
     */
    public function simpanStep1(Pendaftaran $pendaftaran, array $data): void
    {
        DB::transaction(function () use ($pendaftaran, $data) {
            // Update step terakhir
            if ($pendaftaran->step_terakhir < 1) {
                $pendaftaran->update(['step_terakhir' => 1]);
            }

            Siswa::updateOrCreate(
                ['pendaftaran_id' => $pendaftaran->id],
                [
                    'nik' => $data['nik'],
                    'nama_lengkap' => $data['nama_lengkap'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'agama' => $data['agama'],
                    'alamat_lengkap' => $data['alamat_lengkap'],
                    'no_telepon' => $data['no_telepon'] ?? null,
                    'email' => $data['email'] ?? null,
                ]
            );
        });
    }

    /**
     * Step 2 — Simpan data sekolah asal
     */
    public function simpanStep2(Pendaftaran $pendaftaran, array $data): void
    {
        DB::transaction(function () use ($pendaftaran, $data) {
            // Update step terakhir
            if ($pendaftaran->step_terakhir < 2) {
                $pendaftaran->update(['step_terakhir' => 2]);
            }

            SekolahAsal::updateOrCreate(
                ['pendaftaran_id' => $pendaftaran->id],
                [
                    'nisn' => $data['nisn'] ?? null,
                    'nama_sekolah' => $data['nama_sekolah'],
                    'alamat_sekolah' => $data['alamat_sekolah'] ?? null,
                    'tahun_lulus' => $data['tahun_lulus'],
                    'nilai_rata_rata' => $data['nilai_rata_rata'] ?? null,
                ]
            );
        });
    }

    /**
     * Step 3 — Simpan data orang tua
     */
    public function simpanStep3(Pendaftaran $pendaftaran, array $dataAyah, array $dataIbu, ?array $dataWali = null): void
    {
        DB::transaction(function () use ($pendaftaran, $dataAyah, $dataIbu, $dataWali) {
            // Update step terakhir
            if ($pendaftaran->step_terakhir < 3) {
                $pendaftaran->update(['step_terakhir' => 3]);
            }

            // Data Ayah
            if (!empty($dataAyah)) {
                OrangTua::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaran->id, 'jenis' => 'ayah'],
                    [
                        'nama_lengkap' => $dataAyah['nama_lengkap'],
                        'nik' => $dataAyah['nik'] ?? null,
                        'tempat_lahir' => $dataAyah['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $dataAyah['tanggal_lahir'] ?? null,
                        'pekerjaan' => $dataAyah['pekerjaan'] ?? null,
                        'penghasilan' => $dataAyah['penghasilan'] ?? null,
                        'no_telepon' => $dataAyah['no_telepon'] ?? null,
                        'alamat' => $dataAyah['alamat'] ?? null,
                    ]
                );
            }

            // Data Ibu
            if (!empty($dataIbu)) {
                OrangTua::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaran->id, 'jenis' => 'ibu'],
                    [
                        'nama_lengkap' => $dataIbu['nama_lengkap'],
                        'nik' => $dataIbu['nik'] ?? null,
                        'tempat_lahir' => $dataIbu['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $dataIbu['tanggal_lahir'] ?? null,
                        'pekerjaan' => $dataIbu['pekerjaan'] ?? null,
                        'penghasilan' => $dataIbu['penghasilan'] ?? null,
                        'no_telepon' => $dataIbu['no_telepon'] ?? null,
                        'alamat' => $dataIbu['alamat'] ?? null,
                    ]
                );
            }

            // Data Wali (opsional)
            if (!empty($dataWali)) {
                OrangTua::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaran->id, 'jenis' => 'wali'],
                    [
                        'nama_lengkap' => $dataWali['nama_lengkap'],
                        'nik' => $dataWali['nik'] ?? null,
                        'tempat_lahir' => $dataWali['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $dataWali['tanggal_lahir'] ?? null,
                        'pekerjaan' => $dataWali['pekerjaan'] ?? null,
                        'penghasilan' => $dataWali['penghasilan'] ?? null,
                        'no_telepon' => $dataWali['no_telepon'] ?? null,
                        'alamat' => $dataWali['alamat'] ?? null,
                    ]
                );
            }
        });
    }

    /**
     * Step 4 — Simpan pilihan jurusan
     */
    public function simpanStep4(Pendaftaran $pendaftaran, array $data): void
    {
        DB::transaction(function () use ($pendaftaran, $data) {
            // Update step terakhir
            if ($pendaftaran->step_terakhir < 4) {
                $pendaftaran->update(['step_terakhir' => 4]);
            }

            $pendaftaran->update([
                'jurusan_id' => $data['jurusan_id'],
                'jurusan_id_2' => $data['jurusan_id_2'] ?? null,
            ]);
        });
    }

    /**
     * Step 5 — Finalisasi pendaftaran
     */
    public function finalisasi(Pendaftaran $pendaftaran): void
    {
        DB::transaction(function () use ($pendaftaran) {
            $pendaftaran->update([
                'status' => 'menunggu_verifikasi',
                'step_terakhir' => 5,
            ]);

            // Hapus session periode setelah pendaftaran selesai
            $this->clearSelectedPeriode();
        });
    }

    /**
     * Mendapatkan informasi periode untuk pendaftaran tertentu
     */
    public function getPeriodeInfo(Pendaftaran $pendaftaran): array
    {
        $periode = $pendaftaran->pengaturanPpdb;

        return [
            'id' => $periode->id,
            'tahun_ajaran' => $periode->tahun_ajaran,
            'tanggal_buka' => $periode->tanggal_buka,
            'tanggal_tutup' => $periode->tanggal_tutup,
            'tanggal_pengumuman' => $periode->tanggal_pengumuman,
            'biaya' => $periode->biaya_pendaftaran,
            'is_buka' => $periode->isBuka(),
            'sisa_hari' => now()->diffInDays($periode->tanggal_tutup, false),
            'status' => $this->getStatusPeriode($periode),
        ];
    }

    /**
     * Mendapatkan status periode
     */
    public function getStatusPeriode(PengaturanPpdb $periode): string
    {
        if ($periode->tanggal_tutup < now()) {
            return 'berakhir';
        } elseif ($periode->tanggal_buka > now()) {
            return 'akan_datang';
        } else {
            return 'berlangsung';
        }
    }

    /**
     * Mengelompokkan periode berdasarkan status
     */
    public function getPeriodeByStatus(): array
    {
        $allPeriode = $this->getAllPeriodeAktif();

        $grouped = [
            'berlangsung' => [],
            'akan_datang' => [],
            'berakhir' => [],
        ];

        foreach ($allPeriode as $periode) {
            $status = $this->getStatusPeriode($periode);
            $grouped[$status][] = $periode;
        }

        return $grouped;
    }
}