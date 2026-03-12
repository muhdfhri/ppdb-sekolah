{{-- resources/views/admin/pengaturan/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Periode PPDB')

@section('content')

    {{-- ── Breadcrumb & Header ──────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <a href="{{ route('admin.pengaturan.index') }}" class="hover:text-primary transition-colors">Pengaturan</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-slate-600 font-semibold">Edit Periode</span>
            </nav>
            <h2 class="text-3xl font-extrabold tracking-tight">Edit Periode PPDB</h2>
            <p class="text-slate-500 mt-1">Perbarui data periode pendaftaran</p>
        </div>
        <a href="{{ route('admin.pengaturan.index') }}"
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
                <h4 class="font-bold">Form Edit Periode</h4>
                <p class="text-xs text-slate-400">Perbarui data periode pendaftaran PPDB</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.pengaturan.periode.update', $ppdb->id) }}" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Tahun Ajaran --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">calendar_month</span>
                        <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $ppdb->tahun_ajaran) }}"
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('tahun_ajaran') border-red-500 @enderror"
                            placeholder="Contoh: 2026/2027" required>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Format: YYYY/YYYY (contoh: 2026/2027)</p>
                </div>

                {{-- Tanggal Buka --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Tanggal Buka <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">event_available</span>
                        <input type="date" name="tanggal_buka"
                            value="{{ old('tanggal_buka', $ppdb->tanggal_buka->format('Y-m-d')) }}"
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('tanggal_buka') border-red-500 @enderror"
                            required>
                    </div>
                </div>

                {{-- Tanggal Tutup --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Tanggal Tutup <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">event_busy</span>
                        <input type="date" name="tanggal_tutup"
                            value="{{ old('tanggal_tutup', $ppdb->tanggal_tutup->format('Y-m-d')) }}"
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('tanggal_tutup') border-red-500 @enderror"
                            required>
                    </div>
                </div>

                {{-- Tanggal Pengumuman --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tanggal
                        Pengumuman</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">campaign</span>
                        <input type="date" name="tanggal_pengumuman"
                            value="{{ old('tanggal_pengumuman', $ppdb->tanggal_pengumuman?->format('Y-m-d')) }}"
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>
                </div>

                {{-- Biaya Pendaftaran --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Biaya Pendaftaran
                        (Rp)</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">payments</span>
                        <input type="number" name="biaya_pendaftaran"
                            value="{{ old('biaya_pendaftaran', $ppdb->biaya_pendaftaran) }}" min="0"
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('biaya_pendaftaran') border-red-500 @enderror"
                            placeholder="0 = Gratis">
                    </div>
                </div>

                {{-- Mulai Daftar Ulang --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Mulai Daftar
                        Ulang</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">event</span>
                        <input type="date" name="tanggal_daftar_ulang_mulai"
                            value="{{ old('tanggal_daftar_ulang_mulai', $ppdb->tanggal_daftar_ulang_mulai?->format('Y-m-d')) }}"
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>
                </div>

                {{-- Selesai Daftar Ulang --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Selesai Daftar
                        Ulang</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">event_available</span>
                        <input type="date" name="tanggal_daftar_ulang_selesai"
                            value="{{ old('tanggal_daftar_ulang_selesai', $ppdb->tanggal_daftar_ulang_selesai?->format('Y-m-d')) }}"
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>
                </div>

                {{-- Status Aktif --}}
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                            class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary" {{ old('is_active', $ppdb->is_active ?? true) ? 'checked' : '' }}>
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Aktifkan periode ini
                        </span>
                    </label>
                    <p class="text-xs text-slate-400 mt-1 ml-8">
                        Periode yang aktif akan tersedia untuk dipilih siswa saat mendaftar.
                        <span class="font-semibold">Sistem mendukung multiple periode aktif.</span>
                    </p>
                </div>
            </div>

            {{-- Informasi Tambahan --}}
            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                <div class="flex items-start gap-3">
                    <span
                        class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm shrink-0 mt-0.5">info</span>
                    <div class="text-xs text-blue-800 dark:text-blue-300">
                        <p class="font-semibold mb-1">Catatan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Tanggal tutup harus setelah tanggal buka</li>
                            <li>Tanggal selesai daftar ulang harus setelah tanggal mulai daftar ulang</li>
                            <li>Biaya pendaftaran diisi 0 jika gratis</li>
                            <li>Hanya satu periode yang bisa aktif dalam satu waktu</li>
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
                    Update Periode
                </button>
            </div>
        </form>
    </div>

    {{-- JavaScript untuk validasi tambahan --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tanggalBuka = document.querySelector('input[name="tanggal_buka"]');
                const tanggalTutup = document.querySelector('input[name="tanggal_tutup"]');
                const tanggalDaftarUlangMulai = document.querySelector('input[name="tanggal_daftar_ulang_mulai"]');
                const tanggalDaftarUlangSelesai = document.querySelector('input[name="tanggal_daftar_ulang_selesai"]');

                if (tanggalBuka && tanggalTutup) {
                    tanggalBuka.addEventListener('change', function () {
                        tanggalTutup.min = this.value;
                    });
                }

                if (tanggalDaftarUlangMulai && tanggalDaftarUlangSelesai) {
                    tanggalDaftarUlangMulai.addEventListener('change', function () {
                        tanggalDaftarUlangSelesai.min = this.value;
                    });
                }
            });
        </script>
    @endpush

@endsection