@extends('layouts.admin')

@section('title', 'Periode PPDB')

@section('content')

{{-- ── Page Header ──────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h2 class="text-3xl font-extrabold tracking-tight">Periode PPDB</h2>
        <p class="text-slate-500 mt-1">Konfigurasi periode dan jurusan penerimaan siswa baru</p>
    </div>
</div>

@if(session('success'))
<div class="flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl text-green-700 dark:text-green-400 text-sm font-semibold">
    <span class="material-symbols-outlined">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- Kolom Kiri: Form Pengaturan PPDB --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Periode PPDB --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">event_note</span>
                <div>
                    <h4 class="font-bold">Periode Pendaftaran</h4>
                    <p class="text-xs text-slate-400">Atur jadwal buka dan tutup PPDB</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="p-8 space-y-6">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran"
                               value="{{ old('tahun_ajaran', $ppdb->tahun_ajaran ?? '') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary"
                               placeholder="2026/2027"/>
                        @error('tahun_ajaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tanggal Buka</label>
                        <input type="date" name="tanggal_buka"
                               value="{{ old('tanggal_buka', $ppdb?->tanggal_buka?->format('Y-m-d') ?? '') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary"/>
                        @error('tanggal_buka') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tanggal Tutup</label>
                        <input type="date" name="tanggal_tutup"
                               value="{{ old('tanggal_tutup', $ppdb?->tanggal_tutup?->format('Y-m-d') ?? '') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary"/>
                        @error('tanggal_tutup') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tanggal Pengumuman</label>
                        <input type="date" name="tanggal_pengumuman"
                               value="{{ old('tanggal_pengumuman', $ppdb?->tanggal_pengumuman?->format('Y-m-d') ?? '') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary"/>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Biaya Pendaftaran (Rp)</label>
                        <input type="number" name="biaya_pendaftaran"
                               value="{{ old('biaya_pendaftaran', $ppdb->biaya_pendaftaran ?? 0) }}"
                               class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary"
                               placeholder="0 = Gratis"/>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Mulai Daftar Ulang</label>
                        <input type="date" name="tanggal_daftar_ulang_mulai"
                               value="{{ old('tanggal_daftar_ulang_mulai', $ppdb?->tanggal_daftar_ulang_mulai?->format('Y-m-d') ?? '') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary"/>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Selesai Daftar Ulang</label>
                        <input type="date" name="tanggal_daftar_ulang_selesai"
                               value="{{ old('tanggal_daftar_ulang_selesai', $ppdb?->tanggal_daftar_ulang_selesai?->format('Y-m-d') ?? '') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary"/>
                    </div>

                    <div class="sm:col-span-2 flex items-center gap-3">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               class="rounded border-slate-300 text-primary focus:ring-primary"
                               {{ old('is_active', $ppdb->is_active ?? true) ? 'checked' : '' }}/>
                        <label for="is_active" class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Aktifkan periode PPDB ini
                        </label>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                    <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity shadow-sm shadow-primary/20">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        {{-- Kuota Jurusan --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">schema</span>
                <div>
                    <h4 class="font-bold">Kuota Jurusan</h4>
                    <p class="text-xs text-slate-400">Atur kapasitas penerimaan per jurusan</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.pengaturan.kuota') }}" class="p-8 space-y-4">
                @csrf @method('PUT')
                @php
                    $iconMap = ['TKJ'=>'router','AKL'=>'calculate','BDP'=>'storefront','MM'=>'movie_creation'];
                @endphp
                @foreach($jurusan ?? [] as $j)
                <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl">
                    <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined">{{ $iconMap[$j->kode_jurusan] ?? 'school' }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold truncate">{{ $j->nama_jurusan }}</p>
                        <p class="text-[10px] text-slate-400">{{ $j->kode_jurusan }}</p>
                    </div>
                    <div class="shrink-0 flex items-center gap-3">
                        <label class="text-xs text-slate-500 font-semibold">Kuota:</label>
                        <input type="number" name="kuota[{{ $j->id }}]"
                               value="{{ $j->kuota }}" min="0" max="999"
                               class="w-20 px-3 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-center font-bold focus:ring-2 focus:ring-primary/20 focus:border-primary"/>
                    </div>
                    <div class="shrink-0">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="aktif[{{ $j->id }}]" value="1"
                                   class="rounded border-slate-300 text-primary focus:ring-primary"
                                   {{ $j->is_active ? 'checked' : '' }}/>
                            <span class="text-xs font-semibold text-slate-500">Aktif</span>
                        </label>
                    </div>
                </div>
                @endforeach
                <div class="pt-4 flex justify-end">
                    <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Simpan Kuota
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Kolom Kanan: Info & Status --}}
    <div class="space-y-6">

        {{-- Status Periode --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800">
                <h4 class="font-bold">Status Periode Aktif</h4>
            </div>
            <div class="p-6 space-y-4">
                @php
                    $buka = $ppdb?->isBuka() ?? false;
                @endphp
                <div class="flex items-center justify-between p-4 rounded-xl {{ $buka ? 'bg-green-50 dark:bg-green-900/20' : 'bg-slate-50 dark:bg-slate-800' }}">
                    <div class="flex items-center gap-3">
                        <div class="size-3 rounded-full {{ $buka ? 'bg-green-500 animate-pulse' : 'bg-slate-300' }}"></div>
                        <span class="text-sm font-bold {{ $buka ? 'text-green-700 dark:text-green-400' : 'text-slate-500' }}">
                            {{ $buka ? 'Pendaftaran Buka' : 'Pendaftaran Tutup' }}
                        </span>
                    </div>
                </div>

                @if($ppdb)
                <div class="space-y-3">
                    @foreach([
                        ['label'=>'Tahun Ajaran',  'value'=>$ppdb->tahun_ajaran],
                        ['label'=>'Buka',          'value'=>$ppdb->tanggal_buka->format('d M Y')],
                        ['label'=>'Tutup',         'value'=>$ppdb->tanggal_tutup->format('d M Y')],
                        ['label'=>'Pengumuman',    'value'=>$ppdb->tanggal_pengumuman?->format('d M Y') ?? '—'],
                        ['label'=>'Biaya',         'value'=>$ppdb->biaya_pendaftaran > 0 ? 'Rp '.number_format($ppdb->biaya_pendaftaran,0,',','.') : 'Gratis'],
                    ] as $row)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-400 text-xs">{{ $row['label'] }}</span>
                        <span class="font-semibold text-xs">{{ $row['value'] }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Info Akun Admin --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800">
                <h4 class="font-bold">Akun Admin</h4>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-extrabold text-lg">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-bold text-sm">{{ auth()->user()->nama_lengkap }}</p>
                        <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-bold rounded-full">
                            Super Admin
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection