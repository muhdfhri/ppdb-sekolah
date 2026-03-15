{{-- resources/views/admin/pengumuman/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')

    {{-- ── Breadcrumb & Header ──────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <a href="{{ route('admin.pengumuman.index') }}" class="hover:text-primary transition-colors">Pengumuman</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-slate-600 font-semibold">Edit Pengumuman</span>
            </nav>
            <h2 class="text-3xl font-extrabold tracking-tight">Edit Pengumuman</h2>
            <p class="text-slate-500 mt-1">Perbarui konten pengumuman PPDB</p>
        </div>
        <a href="{{ route('admin.pengumuman.index') }}"
            class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke Daftar
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
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div
            class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3 bg-slate-50 dark:bg-slate-800/50">
            <span class="material-symbols-outlined text-primary">edit_note</span>
            <div>
                <h4 class="font-bold">Form Edit Pengumuman</h4>
                <p class="text-xs text-slate-400">Perbarui konten pengumuman PPDB</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Judul Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">campaign</span>
                        <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}"
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('judul') border-red-500 @enderror"
                            placeholder="Contoh: Pengumuman Hasil Seleksi" required>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Judul yang menarik dan informatif</p>
                </div>

                {{-- Isi Pengumuman --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Isi Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-4 text-slate-400 text-lg">description</span>
                        <textarea name="isi" rows="10" required
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('isi') border-red-500 @enderror"
                            placeholder="Tuliskan isi pengumuman di sini...">{{ old('isi', $pengumuman->isi) }}</textarea>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Anda dapat menggunakan teks biasa, paragraf, atau poin-poin</p>
                </div>

                {{-- Status Publish --}}
                <div class="pt-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1"
                            class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary"
                            {{ old('is_published', $pengumuman->is_published) ? 'checked' : '' }}>
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Publikasikan pengumuman
                        </span>
                    </label>
                    <p class="text-xs text-slate-400 mt-1 ml-8">
                        Jika dicentang, pengumuman akan langsung tampil di halaman publik dan terhitung sejak sekarang.
                        <br>Jika tidak dicentang, pengumuman akan disimpan sebagai draft.
                    </p>
                </div>
            </div>

            {{-- Informasi Tambahan --}}
            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                <div class="flex items-start gap-3">
                    <span
                        class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm shrink-0 mt-0.5">info</span>
                    <div class="text-xs text-blue-800 dark:text-blue-300">
                        <p class="font-semibold mb-1">Informasi:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pengumuman yang dipublikasi akan muncul di halaman utama website</li>
                            <li>Pengumuman draft hanya bisa dilihat oleh admin</li>
                            <li>Anda dapat mengubah status publikasi kapan saja dari halaman daftar</li>
                            <li>Tanggal publikasi akan tercatat otomatis saat pertama kali dipublikasi</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Preview Info Card --}}
            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3 mb-3">
                    <span class="material-symbols-outlined text-primary text-sm">preview</span>
                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Informasi Pengumuman</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div>
                        <p class="text-slate-400">Dibuat oleh</p>
                        <p class="font-semibold text-slate-700 dark:text-slate-300">{{ $pengumuman->createdBy->nama_lengkap ?? 'Admin' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Dibuat tanggal</p>
                        <p class="font-semibold text-slate-700 dark:text-slate-300">{{ $pengumuman->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    @if($pengumuman->tanggal_publish)
                        <div>
                            <p class="text-slate-400">Terakhir dipublikasi</p>
                            <p class="font-semibold text-slate-700 dark:text-slate-300">{{ $pengumuman->tanggal_publish->format('d M Y, H:i') }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-slate-400">Status saat ini</p>
                        <p class="font-semibold">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                                style="{{ $pengumuman->is_published
    ? 'background-color: rgba(22,163,74,0.1); color: #16a34a;'
    : 'background-color: rgba(100,116,139,0.1); color: #64748b;' }}">
                                <span class="w-1.5 h-1.5 rounded-full" 
                                    style="background-color: {{ $pengumuman->is_published ? '#16a34a' : '#64748b' }};"></span>
                                {{ $pengumuman->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.pengumuman.index') }}"
                    class="px-6 py-3 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Update Pengumuman
                </button>
            </div>
        </form>
    </div>

    {{-- JavaScript untuk preview sederhana (opsional) --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Anda bisa menambahkan preview real-time jika diinginkan
                const judulInput = document.querySelector('input[name="judul"]');
                const isiTextarea = document.querySelector('textarea[name="isi"]');

                // Contoh: validasi panjang karakter
                if (judulInput) {
                    judulInput.addEventListener('input', function () {
                        if (this.value.length > 255) {
                            this.classList.add('border-red-500');
                        } else {
                            this.classList.remove('border-red-500');
                        }
                    });
                }
            });
        </script>
    @endpush

@endsection