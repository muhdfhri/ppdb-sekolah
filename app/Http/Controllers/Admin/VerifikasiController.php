<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\VerifikasiService;
use App\Models\Dokumen;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function __construct(
        private VerifikasiService $verifikasiService
    ) {
    }

    public function index()
    {
        $pendingVerifikasi = $this->verifikasiService->getPendingVerifikasi(20);

        return view('admin.verifikasi.index', compact('pendingVerifikasi'));
    }

    public function verifikasiDokumen(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:valid,tidak_valid',
            'catatan' => 'nullable|string|max:500',
        ]);

        $dokumen = Dokumen::findOrFail($id);
        $result = $this->verifikasiService->verifikasiDokumen(
            $dokumen,
            $request->status,
            $request->catatan
        );

        return response()->json([
            'success' => true,
            'status_verifikasi' => $result->status_verifikasi,
        ]);
    }
}