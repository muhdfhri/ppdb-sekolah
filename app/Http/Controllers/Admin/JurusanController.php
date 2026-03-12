<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusan = Jurusan::orderBy('kode_jurusan')->get();
        return view('admin.kelolajurusan.index', compact('jurusan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kelolajurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusan,kode_jurusan',
            'nama_jurusan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|numeric|min:0|max:999',
            'is_active' => 'nullable|boolean',
        ]);

        Jurusan::create([
            'kode_jurusan' => strtoupper($request->kode_jurusan),
            'nama_jurusan' => $request->nama_jurusan,
            'deskripsi' => $request->deskripsi,
            'kuota' => $request->kuota,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return response()->json($jurusan);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.kelolajurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusan,kode_jurusan,' . $id,
            'nama_jurusan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|numeric|min:0|max:999',
            'is_active' => 'nullable|boolean',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'kode_jurusan' => strtoupper($request->kode_jurusan),
            'nama_jurusan' => $request->nama_jurusan,
            'deskripsi' => $request->deskripsi,
            'kuota' => $request->kuota,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->is_active = !$jurusan->is_active;
        $jurusan->save();

        $status = $jurusan->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.pengaturan.index')
            ->with('success', "Jurusan berhasil {$status}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        // Cek apakah jurusan sudah digunakan di pendaftaran
        if ($jurusan->pendaftaran()->count() > 0) {
            return redirect()->route('admin.pengaturan.index')
                ->with('error', 'Jurusan tidak dapat dihapus karena sudah memiliki data pendaftaran.');
        }

        $jurusan->delete();

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}