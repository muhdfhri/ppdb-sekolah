<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PengumumanService;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function __construct(
        private PengumumanService $pengumumanService
    ) {
    }

    public function index()
    {
        $pengumuman = Pengumuman::with('createdBy')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        $this->pengumumanService->create($request->all());

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $this->pengumumanService->update($pengumuman, $request->all());

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function togglePublish($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $result = $this->pengumumanService->togglePublish($pengumuman);

        return response()->json([
            'success' => true,
            'is_published' => $result->is_published,
        ]);
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $this->pengumumanService->delete($pengumuman);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}