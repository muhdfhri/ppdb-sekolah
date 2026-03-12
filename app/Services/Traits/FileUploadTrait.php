<?php

namespace App\Services\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileUploadTrait
{
    /**
     * Upload file ke storage
     */
    public function uploadFile(UploadedFile $file, $path, $disk = 'public'): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . Str::slug($originalName) . '_' . Str::random(5) . '.' . $extension;

        $filePath = $file->storeAs($path, $filename, $disk);

        return $filePath;
    }

    /**
     * Hapus file dari storage
     */
    public function deleteFile($path, $disk = 'public'): bool
    {
        if (empty($path)) {
            return false;
        }

        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Generate path untuk dokumen
     */
    public function generateDokumenPath(int $pendaftaranId, string $jenis): string
    {
        return "dokumen/{$pendaftaranId}/{$jenis}";
    }
}