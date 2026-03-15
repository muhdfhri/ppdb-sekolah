{{-- resources/views/admin/pengumuman/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Buat Pengumuman')

@section('content')

{{-- ── Breadcrumb ────────────────────────────────────────── --}}
<div class="flex items-center gap-2 text-sm text-slate-400">
    <a href="{{ route('admin.pengumuman.index') }}"
        class="hover:text-primary transition-colors font-medium">Pengumuman</a>
    <span class="material-symbols-outlined text-base">chevron_right</span>
    <span class="text-slate-700 dark:text-slate-200 font-semibold">Buat Baru</span>
</div>

{{-- ── Page Header ───────────────────────────────────────── --}}
<div class="flex items-center gap-4">
    <a href="{{ route('admin.pengumuman.index') }}"
        class="size-10 rounded-xl flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors bg-slate-100">
        <span class="material-symbols-outlined text-lg">arrow_back</span>
    </a>
    <div>
        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Buat Pengumuman Baru</h2>
        <p class="text-sm text-slate-500 mt-0.5">Isi judul dan konten pengumuman di bawah ini.</p>
    </div>
</div>

{{-- ── Form ──────────────────────────────────────────────── --}}
<form action="{{ route('admin.pengumuman.store') }}" method="POST" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri: Form Utama --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Card --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-5">

                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Judul Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm outline-none transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary"
                        placeholder="Contoh: Pengumuman Hasil Seleksi PPDB 2026/2027"
                        required>
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">error</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Isi --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Isi Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <textarea name="isi" rows="14"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm outline-none transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary resize-none"
                        placeholder="Tuliskan isi pengumuman di sini..."
                        required>{{ old('isi') }}</textarea>
                    @error('isi')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">error</span> {{ $message }}
                        </p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-1.5">
                        <span class="material-symbols-outlined text-sm align-middle">info</span>
                        Gunakan baris baru untuk memisahkan paragraf.
                    </p>
                </div>

            </div>
        </div>

        {{-- Kolom Kanan: Settings --}}
        <div class="space-y-5">

            {{-- Publish Card --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
                <h3 class="font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-base text-primary">settings</span>
                    Pengaturan Publikasi
                </h3>

                {{-- Toggle is_published --}}
                <label class="flex items-center justify-between gap-4 p-4 rounded-xl cursor-pointer transition-all"
                    style="background-color: rgba(1,137,62,0.04); border: 1px solid rgba(1,137,62,0.12);"
                    id="publish-wrapper">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded-xl flex items-center justify-center"
                            style="background-color: rgba(1,137,62,0.1);">
                            <span class="material-symbols-outlined text-base" style="color: #01893e;">visibility</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-white">Publish Sekarang</p>
                            <p class="text-xs text-slate-400">Langsung tampil ke pendaftar</p>
                        </div>
                    </div>
                    <div class="relative shrink-0">
                        <input type="checkbox" name="is_published" value="1" id="toggle-publish"
                            class="sr-only peer" {{ old('is_published') ? 'checked' : '' }}>
                        <div class="w-11 h-6 rounded-full peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all transition-colors"
                            style="background-color: #e2e8f0;"
                            id="toggle-bg"></div>
                    </div>
                </label>

                <p class="text-xs text-slate-400 leading-relaxed">
                    Jika dinonaktifkan, pengumuman akan tersimpan sebagai <strong>Draft</strong> dan tidak terlihat oleh pendaftar.
                </p>

            </div>

            {{-- Info Card --}}
            <div class="rounded-2xl p-5 space-y-3"
                style="background-color: rgba(246,203,4,0.08); border: 1px solid rgba(246,203,4,0.25);">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-base" style="color: #d4a400;">info</span>
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Info</p>
                </div>
                <ul class="text-xs text-slate-500 space-y-1.5 leading-relaxed">
                    <li>• Pengumuman otomatis terikat ke periode PPDB yang sedang aktif.</li>
                    <li>• Tanggal publish tercatat saat pertama kali dipublish.</li>
                    <li>• Kamu bisa mengubah status publish kapan saja dari halaman daftar.</li>
                </ul>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col gap-3">
                <button type="submit"
                    class="w-full py-3 rounded-xl font-bold text-white text-sm flex items-center justify-center gap-2 transition-all hover:opacity-90 shadow-sm"
                    style="background-color: #01893e;">
                    <span class="material-symbols-outlined text-base">save</span>
                    Simpan Pengumuman
                </button>
                <a href="{{ route('admin.pengumuman.index') }}"
                    class="w-full py-3 rounded-xl font-bold text-slate-600 text-sm flex items-center justify-center gap-2 transition-colors bg-slate-100 hover:bg-slate-200 text-center">
                    <span class="material-symbols-outlined text-base">close</span>
                    Batal
                </a>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
// Live preview toggle styling
const toggle = document.getElementById('toggle-publish');
const toggleBg = document.getElementById('toggle-bg');

function updateToggleStyle() {
    if (toggle.checked) {
        toggleBg.style.backgroundColor = '#01893e';
    } else {
        toggleBg.style.backgroundColor = '#e2e8f0';
    }
}

toggle.addEventListener('change', updateToggleStyle);
updateToggleStyle(); // init
</script>
@endpush