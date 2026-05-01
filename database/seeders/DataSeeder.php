<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data periode PPDB aktif
        $periodeAktif = DB::table('pengaturan_ppdb')->where('is_active', 1)->first();

        if (!$periodeAktif) {
            $this->command->error('Tidak ada periode PPDB aktif!');
            return;
        }

        // Ambil data jurusan yang aktif
        $jurusan = DB::table('jurusan')->where('is_active', 1)->get();

        if ($jurusan->isEmpty()) {
            $this->command->error('Tidak ada jurusan aktif!');
            return;
        }

        // Daftar user yang akan dibuat pendaftarannya (kecuali Suci Rahmayani email: suci@gmail.com)
        $users = DB::table('users')
            ->where('email', '!=', 'suci@gmail.com')
            ->where('role', 'siswa')
            ->limit(10)
            ->get();

        if ($users->isEmpty()) {
            $this->command->error('Tidak ada user siswa yang ditemukan!');
            return;
        }

        // Status yang akan diberikan
        // Diterima: 5 orang, Ditolak: 1 orang, Menunggu Verifikasi: 4 orang
        $statusList = [
            'diterima',      // 1
            'diterima',      // 2
            'diterima',      // 3
            'diterima',      // 4
            'diterima',      // 5
            'ditolak',       // 6
            'menunggu_verifikasi', // 7
            'menunggu_verifikasi', // 8
            'menunggu_verifikasi', // 9
            'menunggu_verifikasi', // 10
        ];

        // Data sekolah asal contoh
        $sekolahAsal = [
            'SMP Negeri 1 Medan',
            'SMP Negeri 2 Medan',
            'SMP Swasta Teladan',
            'MTs Negeri 1 Medan',
            'SMP Negeri 5 Medan',
            'SMP Swasta Budi Mulia',
            'MTs Swasta Al-Washliyah',
            'SMP Negeri 8 Medan',
            'SMP Swasta Islam Terpadu',
            'SMP Negeri 12 Medan',
        ];

        // Data alamat contoh
        $alamatList = [
            'Jl. Pendidikan No. 10, Medan',
            'Jl. Merdeka No. 25, Medan',
            'Jl. Sudirman No. 5, Medan',
            'Jl. Thamrin No. 8, Medan',
            'Jl. Diponegoro No. 15, Medan',
            'Jl. Pahlawan No. 20, Medan',
            'Jl. Karya No. 12, Medan',
            'Jl. Mawar No. 7, Medan',
            'Jl. Melati No. 3, Medan',
            'Jl. Kenanga No. 9, Medan',
        ];

        // Data nama orang tua contoh
        $namaOrtu = [
            'Ahmad Supriyadi',
            'Budi Setiawan',
            'Siti Aminah',
            'Dedi Irawan',
            'Rina Marlina',
            'Hendra Wijaya',
            'Lilis Suryani',
            'Rudi Hartono',
            'Dewi Sartika',
            'Eko Prasetyo',
        ];

        $counter = 0;

        foreach ($users as $index => $user) {
            $status = $statusList[$index];

            // Pilih jurusan berdasarkan kuota yang tersedia (acak)
            $selectedJurusan = $jurusan->random();
            $selectedJurusan2 = $jurusan->where('id', '!=', $selectedJurusan->id)->random();

            // Generate nomor pendaftaran unik
            $nomorPendaftaran = 'PPDB-' . date('Y') . '-' . str_pad($counter + 1, 4, '0', STR_PAD_LEFT);

            // Tentukan tanggal daftar (acak antara tanggal buka dan sekarang)
            $tanggalBuka = Carbon::parse($periodeAktif->tanggal_buka);
            $tanggalDaftar = $tanggalBuka->copy()->addDays(rand(0, 30));

            // Tentukan status verifikasi berdasarkan status pendaftaran
            $verificationStatus = $this->getVerificationStatus($status);

            // Insert data pendaftaran
            $pendaftaranId = DB::table('pendaftaran')->insertGetId([
                'user_id' => $user->id,
                'pengaturan_ppdb_id' => $periodeAktif->id,
                'jurusan_id' => $selectedJurusan->id,
                'jurusan_id_2' => $selectedJurusan2->id,
                'nomor_pendaftaran' => $nomorPendaftaran,
                'tanggal_daftar' => $tanggalDaftar,
                'status' => $status,
                'catatan_admin' => $status == 'ditolak' ? 'Maaf, berkas tidak lengkap dan nilai tidak memenuhi syarat.' : null,
                'step_terakhir' => 5,
                'created_at' => $tanggalDaftar,
                'updated_at' => now(),
            ]);

            // Insert data siswa
            DB::table('siswa')->insert([
                'pendaftaran_id' => $pendaftaranId,
                'nik' => '12' . rand(1000000000000, 9999999999999),
                'nama_lengkap' => $user->nama_lengkap,
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => Carbon::createFromDate(rand(2006, 2009), rand(1, 12), rand(1, 28)),
                'jenis_kelamin' => $index % 2 == 0 ? 'Laki-laki' : 'Perempuan',
                'agama' => $this->getRandomAgama(),
                'alamat_lengkap' => $alamatList[$index % count($alamatList)],
                'no_telepon' => '08' . rand(1000000000, 9999999999),
                'email' => $user->email,
                'foto_path' => null,
                'created_at' => $tanggalDaftar,
                'updated_at' => now(),
            ]);

            // Insert data sekolah asal
            DB::table('sekolah_asal')->insert([
                'pendaftaran_id' => $pendaftaranId,
                'nisn' => rand(1000000000, 9999999999),
                'nama_sekolah' => $sekolahAsal[$index % count($sekolahAsal)],
                'alamat_sekolah' => 'Jl. Pendidikan No. ' . ($index + 1) . ', Medan',
                'tahun_lulus' => 2025,
                'nilai_rata_rata' => $this->getRandomNilai($status),
                'created_at' => $tanggalDaftar,
                'updated_at' => now(),
            ]);

            // Insert data orang tua (ayah dan ibu)
            // Ayah
            DB::table('orang_tua')->insert([
                'pendaftaran_id' => $pendaftaranId,
                'jenis' => 'ayah',
                'nama_lengkap' => $namaOrtu[$index % count($namaOrtu)],
                'nik' => '12' . rand(1000000000000, 9999999999999),
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => Carbon::createFromDate(rand(1970, 1985), rand(1, 12), rand(1, 28)),
                'pekerjaan' => $this->getRandomPekerjaan(),
                'penghasilan' => $this->getRandomPenghasilan(),
                'no_telepon' => '08' . rand(1000000000, 9999999999),
                'alamat' => $alamatList[$index % count($alamatList)],
                'created_at' => $tanggalDaftar,
                'updated_at' => now(),
            ]);

            // Ibu
            DB::table('orang_tua')->insert([
                'pendaftaran_id' => $pendaftaranId,
                'jenis' => 'ibu',
                'nama_lengkap' => $this->getNamaIbu($namaOrtu[$index % count($namaOrtu)]),
                'nik' => '12' . rand(1000000000, 9999999999999),
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => Carbon::createFromDate(rand(1972, 1987), rand(1, 12), rand(1, 28)),
                'pekerjaan' => $this->getRandomPekerjaanIbu(),
                'penghasilan' => $this->getRandomPenghasilan(),
                'no_telepon' => '08' . rand(1000000000, 9999999999),
                'alamat' => $alamatList[$index % count($alamatList)],
                'created_at' => $tanggalDaftar,
                'updated_at' => now(),
            ]);

            // Jika status sudah diterima, buat pembayaran yang sudah diverifikasi
            if ($status == 'diterima') {
                DB::table('pembayaran')->insert([
                    'pendaftaran_id' => $pendaftaranId,
                    'jumlah' => $periodeAktif->biaya_pendaftaran,
                    'metode_pembayaran' => 'transfer_bank',
                    'nama_bank' => 'BCA',
                    'nama_pengirim' => $user->nama_lengkap,
                    'nomor_rekening' => rand(1000000000, 9999999999),
                    'bukti_pembayaran_path' => null,
                    'tanggal_bayar' => $tanggalDaftar->copy()->addDays(rand(1, 5)),
                    'status' => 'terverifikasi',
                    'catatan_admin' => null,
                    'verified_by' => 11, // ID admin utama
                    'verified_at' => $tanggalDaftar->copy()->addDays(rand(6, 10)),
                    'created_at' => $tanggalDaftar,
                    'updated_at' => now(),
                ]);
            } elseif ($status == 'menunggu_verifikasi') {
                // Belum ada pembayaran atau masih menunggu
                if (rand(0, 1) == 1) {
                    DB::table('pembayaran')->insert([
                        'pendaftaran_id' => $pendaftaranId,
                        'jumlah' => $periodeAktif->biaya_pendaftaran,
                        'metode_pembayaran' => 'transfer_bank',
                        'nama_bank' => 'Mandiri',
                        'nama_pengirim' => $user->nama_lengkap,
                        'nomor_rekening' => rand(1000000000, 9999999999),
                        'bukti_pembayaran_path' => null,
                        'tanggal_bayar' => $tanggalDaftar->copy()->addDays(rand(1, 3)),
                        'status' => 'menunggu',
                        'catatan_admin' => null,
                        'verified_by' => null,
                        'verified_at' => null,
                        'created_at' => $tanggalDaftar,
                        'updated_at' => now(),
                    ]);
                }
            }

            // Jika ditolak, buat catatan di verifikasi_log
            if ($status == 'ditolak') {
                DB::table('verifikasi_log')->insert([
                    'pendaftaran_id' => $pendaftaranId,
                    'admin_id' => 11,
                    'status_sebelum' => 'menunggu_verifikasi',
                    'status_sesudah' => 'ditolak',
                    'catatan' => 'Berkas tidak lengkap dan nilai rapor tidak memenuhi standar minimal.',
                    'created_at' => $tanggalDaftar->copy()->addDays(rand(5, 10)),
                ]);
            } elseif ($status == 'diterima') {
                // Log penerimaan
                DB::table('verifikasi_log')->insert([
                    'pendaftaran_id' => $pendaftaranId,
                    'admin_id' => 11,
                    'status_sebelum' => 'menunggu_verifikasi',
                    'status_sesudah' => 'terverifikasi',
                    'catatan' => 'Berkas lengkap, nilai memenuhi syarat.',
                    'created_at' => $tanggalDaftar->copy()->addDays(rand(5, 10)),
                ]);

                DB::table('verifikasi_log')->insert([
                    'pendaftaran_id' => $pendaftaranId,
                    'admin_id' => 11,
                    'status_sebelum' => 'terverifikasi',
                    'status_sesudah' => 'diterima',
                    'catatan' => 'Selamat! Anda diterima di jurusan ' . $selectedJurusan->nama_jurusan,
                    'created_at' => $tanggalDaftar->copy()->addDays(rand(11, 15)),
                ]);
            }

            $counter++;
        }

        $this->command->info('DataSeeder berhasil dijalankan!');
        $this->command->info('Diterima: 5 orang');
        $this->command->info('Ditolak: 1 orang');
        $this->command->info('Menunggu Verifikasi: 4 orang');
    }

    /**
     * Get verification status based on registration status
     */
    private function getVerificationStatus($status)
    {
        switch ($status) {
            case 'diterima':
                return 'valid';
            case 'ditolak':
                return 'tidak_valid';
            default:
                return 'menunggu';
        }
    }

    /**
     * Get random agama
     */
    private function getRandomAgama()
    {
        $agama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];
        return $agama[array_rand($agama)];
    }

    /**
     * Get random pekerjaan untuk ayah
     */
    private function getRandomPekerjaan()
    {
        $pekerjaan = [
            'PNS',
            'Swasta',
            'Wiraswasta',
            'Petani',
            'Nelayan',
            'Buruh',
            'Guru',
            'Dokter',
            'Polisi',
            'TNI'
        ];
        return $pekerjaan[array_rand($pekerjaan)];
    }

    /**
     * Get random pekerjaan untuk ibu
     */
    private function getRandomPekerjaanIbu()
    {
        $pekerjaan = [
            'Ibu Rumah Tangga',
            'PNS',
            'Guru',
            'Perawat',
            'Swasta',
            'Wiraswasta',
            'Pedagang'
        ];
        return $pekerjaan[array_rand($pekerjaan)];
    }

    /**
     * Get random penghasilan
     */
    private function getRandomPenghasilan()
    {
        $penghasilan = ['kurang_1jt', '1jt_3jt', '3jt_5jt', '5jt_10jt', 'lebih_10jt'];
        return $penghasilan[array_rand($penghasilan)];
    }

    /**
     * Get random nilai berdasarkan status
     */
    private function getRandomNilai($status)
    {
        if ($status == 'diterima') {
            // Nilai tinggi untuk yang diterima
            return rand(85, 95) + (rand(0, 99) / 100);
        } elseif ($status == 'ditolak') {
            // Nilai rendah untuk yang ditolak
            return rand(60, 74) + (rand(0, 99) / 100);
        } else {
            // Nilai sedang untuk yang menunggu
            return rand(75, 84) + (rand(0, 99) / 100);
        }
    }

    /**
     * Get nama ibu dari nama ayah
     */
    private function getNamaIbu($namaAyah)
    {
        // Pisahkan nama depan dan belakang
        $namaDepan = explode(' ', $namaAyah)[0];

        $namaIbuList = [
            'Ahmad' => 'Siti Aisyah',
            'Budi' => 'Siti Maimunah',
            'Siti' => 'Nur Asiah',
            'Dedi' => 'Rina Marlina',
            'Rina' => 'Dewi Sartika',
            'Hendra' => 'Lilis Suryani',
            'Lilis' => 'Nur Halimah',
            'Rudi' => 'Sumarni',
            'Dewi' => 'Sri Rahayu',
            'Eko' => 'Yuni Astuti',
        ];

        return $namaIbuList[$namaDepan] ?? 'Siti ' . $namaDepan . 'ah';
    }
}