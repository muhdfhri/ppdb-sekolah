<?php

namespace App\Services\Admin;

use App\Models\Pengumuman;
use App\Models\PengaturanPpdb;
use Illuminate\Support\Facades\Auth;

class PengumumanService
{
    // ================================================================
    // CREATE
    // Dipanggil dari Admin\PengumumanController::store()
    // ================================================================

    public function create(array $data): Pengumuman
    {
        $ppdb = PengaturanPpdb::where('is_active', true)->firstOrFail();

        $isPublished = filter_var($data['is_published'] ?? false, FILTER_VALIDATE_BOOLEAN);

        return Pengumuman::create([
            'pengaturan_ppdb_id' => $ppdb->id,
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'is_published' => $isPublished,
            'tanggal_publish' => $isPublished ? now() : null,
            'created_by' => Auth::id(),
        ]);
    }

    // ================================================================
    // UPDATE
    // Dipanggil dari Admin\PengumumanController::update()
    // ================================================================

    public function update(Pengumuman $pengumuman, array $data): Pengumuman
    {
        $isPublished = filter_var($data['is_published'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Set tanggal_publish hanya saat pertama kali dipublish
        $tanggalPublish = $pengumuman->tanggal_publish;
        if ($isPublished && !$pengumuman->is_published) {
            $tanggalPublish = now();
        } elseif (!$isPublished) {
            $tanggalPublish = null;
        }

        $pengumuman->update([
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'is_published' => $isPublished,
            'tanggal_publish' => $tanggalPublish,
        ]);

        return $pengumuman->fresh();
    }

    // ================================================================
    // TOGGLE PUBLISH
    // Aksi cepat publish/unpublish langsung dari tabel index
    // ================================================================

    public function togglePublish(Pengumuman $pengumuman): Pengumuman
    {
        $nowPublished = !$pengumuman->is_published;

        $pengumuman->update([
            'is_published' => $nowPublished,
            'tanggal_publish' => $nowPublished ? now() : null,
        ]);

        return $pengumuman->fresh();
    }

    // ================================================================
    // DELETE
    // Dipanggil dari Admin\PengumumanController::destroy()
    // ================================================================

    public function delete(Pengumuman $pengumuman): void
    {
        $pengumuman->delete();
    }
}