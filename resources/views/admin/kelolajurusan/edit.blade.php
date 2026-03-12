{{-- resources/views/admin/kelolajurusan/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Jurusan')

@section('content')

{{-- ── Breadcrumb & Header ──────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a href="{{ route('admin.pengaturan.index') }}" class="hover:text-primary transition-colors">Pengaturan</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-slate-600 font-semibold">Edit Jurusan</span>
        </nav>
        <h2 class="text-3xl font-extrabold tracking-tight">Edit Jurusan</h2>
        <p class="text-slate-500 mt-1">Perbarui data jurusan/program keahlian</p>
    </div>
    <a href="{{ route('admin.pengaturan.index') }}"
        class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
        <span class="material-symbols-outlined text-lg">arrow_back</span>
        Kembali ke Pengaturan
    </a>
</div>

{{-- Alert Error --}}
@if($errors->any())
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
        <div class="flex items-center gap-2 text-red-700 dark:text-red-400 font-semibold mb-2">
            <span class="material-symbols-outlined text-sm">error</span>
            <span class="text-sm">Terdapat kesalahan pada form:</span>
        </div>
        <ul class="list-disc list-inside text-xs text-red-600 dark:text-red-400 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ── Form Card ─────────────────────────────────────────── --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
    <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3 bg-slate-50 dark:bg-slate-800/50">
        <span class="material-symbols-outlined text-primary">edit_note</span>
        <div>
            <h4 class="font-bold">Form Edit Jurusan</h4>
            <p class="text-xs text-slate-400">Edit data jurusan/program keahlian</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.jurusan.update', $jurusan->id) }}" class="p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kode Jurusan --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Kode Jurusan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">tag</span>
                    <input type="text" name="kode_jurusan" value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" maxlength="10" required
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all uppercase @error('kode_jurusan') border-red-500 @enderror"
                        placeholder="Contoh: TKJ, AKL, BDP, MM">
                </div>
                <p class="text-xs text-slate-400 mt-1">Maksimal 10 karakter, akan otomatis uppercase</p>
                @error('kode_jurusan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nama Jurusan --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Nama Jurusan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">school</span>
                    <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('nama_jurusan') border-red-500 @enderror"
                        placeholder="Contoh: Teknik Komputer & Jaringan">
                </div>
                @error('nama_jurusan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Kuota --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Kuota <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">group</span>
                    <input type="number" name="kuota" value="{{ old('kuota', $jurusan->kuota) }}" min="0" max="999" required
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('kuota') border-red-500 @enderror"
                        placeholder="Contoh: 120">
                </div>
                <p class="text-xs text-slate-400 mt-1">Jumlah maksimal siswa yang dapat diterima</p>
                @error('kuota') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Status Aktif --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Status</label>
                <div class="flex items-center gap-3 h-full pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                            class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary"
                            {{ old('is_active', $jurusan->is_active) ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            Aktifkan jurusan ini
                        </span>
                    </label>
                </div>
                <p class="text-xs text-slate-400 mt-1 ml-7">Jurusan aktif akan tersedia untuk dipilih siswa</p>
            </div>

            {{-- Deskripsi --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Deskripsi Jurusan</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-4 text-slate-400 text-lg">description</span>
                    <textarea name="deskripsi" rows="4"
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all resize-none @error('deskripsi') border-red-500 @enderror"
                        placeholder="Jelaskan secara singkat tentang jurusan ini, prospek karir, atau mata pelajaran yang akan dipelajari...">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>
                </div>
                @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Preview Icon --}}
        <div class="p-4 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
            <p class="text-xs font-semibold text-slate-500 mb-3">PREVIEW ICON JURUSAN</p>
            <div class="flex items-center gap-6">
                @php
                    $icons = [
                        'TKJ' => ['icon' => 'router', 'color' => 'bg-blue-100 text-blue-600'],
                        'AKL' => ['icon' => 'calculate', 'color' => 'bg-green-100 text-green-600'],
                        'BDP' => ['icon' => 'storefront', 'color' => 'bg-purple-100 text-purple-600'],
                        'MM' => ['icon' => 'movie_creation', 'color' => 'bg-orange-100 text-orange-600'],
                        'TKR' => ['icon' => 'settings', 'color' => 'bg-red-100 text-red-600'],
                    ];
                @endphp
                @foreach($icons as $kode => $data)
                <div class="flex flex-col items-center gap-1">
                    <div class="size-10 rounded-lg {{ $data['color'] }} flex items-center justify-center">
                        <span class="material-symbols-outlined">{{ $data['icon'] }}</span>
                    </div>
                    <span class="text-[10px] font-bold">{{ $kode }}</span>
                </div>
                @endforeach
                <div class="flex flex-col items-center gap-1">
                    <div class="size-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">school</span>
                    </div>
                    <span class="text-[10px] font-bold">Default</span>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-3">Icon akan otomatis menyesuaikan dengan kode jurusan yang dimasukkan</p>
        </div>

        {{-- Informasi Tambahan --}}
        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm shrink-0 mt-0.5">info</span>
                <div class="text-xs text-blue-800 dark:text-blue-300">
                    <p class="font-semibold mb-1">Catatan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Kode jurusan harus unik dan tidak boleh sama dengan jurusan lain</li>
                        <li>Kuota dapat diubah kembali melalui halaman pengaturan</li>
                        <li>Jurusan yang dinonaktifkan tidak akan muncul di pilihan siswa</li>
                        <li>Icon akan menyesuaikan dengan kode jurusan (TKJ, AKL, BDP, MM, TKR, dll)</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
            <a href="{{ route('admin.pengaturan.index') }}"
                class="px-6 py-3 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                Batal
            </a>
            <button type="submit"
                class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">save</span>
                Update Jurusan
            </button>
        </div>
    </form>
</div>

{{-- JavaScript untuk validasi tambahan --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto uppercase untuk kode jurusan
        const kodeJurusan = document.querySelector('input[name="kode_jurusan"]');
        if (kodeJurusan) {
            kodeJurusan.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }
    });
</script>
@endpush

@endsection