<?php

namespace App\Services\Siswa;

use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Http\UploadedFile;
use App\Services\Traits\FileUploadTrait;

class DokumenService
{
    use FileUploadTrait;

    /**
     * Simpan dokumen yang diupload
     */
    public function simpan(Pendaftaran $pendaftaran, string $jenis, UploadedFile $file): Dokumen
    {
        // Generate path untuk penyimpanan
        $path = $this->generateDokumenPath($pendaftaran->id, $jenis);

        // Upload file dan dapatkan path lengkap
        $filePath = $this->uploadFile($file, $path);

        // Simpan ke database dengan file_path
        return Dokumen::updateOrCreate(
            [
                'pendaftaran_id' => $pendaftaran->id,
                'jenis_dokumen' => $jenis,
            ],
            [
                'nama_file' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'ukuran_file' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'status_verifikasi' => 'menunggu',
            ]
        );
    }

    /**
     * Hapus dokumen
     */
    public function hapus(Dokumen $dokumen): bool
    {
        // Hapus file dari storage
        $this->deleteFile($dokumen->file_path);

        // Hapus record dari database
        return $dokumen->delete();
    }

    /**
     * Verifikasi dokumen
     */
    public function verifikasi(Dokumen $dokumen, string $status, ?string $catatan = null): Dokumen
    {
        $dokumen->status_verifikasi = $status;
        $dokumen->catatan = $catatan;
        $dokumen->save();

        return $dokumen;
    }

    /**
     * Get semua dokumen untuk pendaftaran tertentu
     */
    public function getDokumenByPendaftaran(Pendaftaran $pendaftaran)
    {
        return $pendaftaran->dokumen()->get()->keyBy('jenis_dokumen');
    }

    /**
     * Cek apakah dokumen sudah lengkap
     */
    public function cekKelengkapan(Pendaftaran $pendaftaran): bool
    {
        $requiredDokumen = ['ijazah', 'kartu_keluarga', 'akte_kelahiran', 'pas_foto'];
        $existingDokumen = $pendaftaran->dokumen()
            ->whereIn('jenis_dokumen', $requiredDokumen)
            ->count();

        return $existingDokumen === count($requiredDokumen);
    }

    /**
     * Update dokumen yang sudah ada
     */
    public function update(Dokumen $dokumen, UploadedFile $file): Dokumen
    {
        // Hapus file lama
        $this->deleteFile($dokumen->file_path);

        // Upload file baru
        $path = $this->generateDokumenPath($dokumen->pendaftaran_id, $dokumen->jenis_dokumen);
        $filePath = $this->uploadFile($file, $path);

        // Update database
        $dokumen->nama_file = $file->getClientOriginalName();
        $dokumen->file_path = $filePath;
        $dokumen->ukuran_file = $file->getSize();
        $dokumen->mime_type = $file->getMimeType();
        $dokumen->status_verifikasi = 'menunggu';
        $dokumen->save();

        return $dokumen;
    }
}