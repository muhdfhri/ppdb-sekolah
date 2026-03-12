{{-- resources/views/admin/pengaturan/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Periode PPDB')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <a href="{{ route('admin.pengaturan.index') }}" class="hover:text-primary">Pengaturan</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-slate-600 font-semibold">Detail Periode</span>
            </nav>
            <h2 class="text-3xl font-extrabold tracking-tight">Detail Periode PPDB</h2>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pengaturan.index') }}"
                class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
            <a href="{{ route('admin.pengaturan.periode.edit', $ppdb->id) }}"
                class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-lg">edit</span>
                Edit
            </a>
        </div>
    </div>

    {{-- Konten Detail (menggunakan pengaturan blade yang sudah ada) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Kolom Kiri: Detail Periode --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">event_note</span>
                    <h4 class="font-bold">Detail Periode Pendaftaran</h4>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @php
                            $detailPeriode = [
                                ['label' => 'Tahun Ajaran', 'value' => $ppdb->tahun_ajaran],
                                ['label' => 'Tanggal Buka', 'value' => $ppdb->tanggal_buka->format('d F Y')],
                                ['label' => 'Tanggal Tutup', 'value' => $ppdb->tanggal_tutup->format('d F Y')],
                                ['label' => 'Tanggal Pengumuman', 'value' => $ppdb->tanggal_pengumuman ? $ppdb->tanggal_pengumuman->format('d F Y') : 'Belum ditentukan'],
                                ['label' => 'Biaya Pendaftaran', 'value' => $ppdb->biaya_pendaftaran > 0 ? 'Rp ' . number_format($ppdb->biaya_pendaftaran, 0, ',', '.') : 'Gratis'],
                                ['label' => 'Mulai Daftar Ulang', 'value' => $ppdb->tanggal_daftar_ulang_mulai ? $ppdb->tanggal_daftar_ulang_mulai->format('d F Y') : 'Belum ditentukan'],
                                ['label' => 'Selesai Daftar Ulang', 'value' => $ppdb->tanggal_daftar_ulang_selesai ? $ppdb->tanggal_daftar_ulang_selesai->format('d F Y') : 'Belum ditentukan'],
                                ['label' => 'Status', 'value' => $ppdb->is_active ? 'Aktif' : 'Tidak Aktif'],
                            ];
                        @endphp
                        @foreach($detailPeriode as $field)
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                    {{ $field['label'] }}</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $field['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Info & Status --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h4 class="font-bold">Status Periode</h4>
                </div>
                <div class="p-6">
                    @php
                        $buka = $ppdb->isBuka();
                    @endphp
                    <div
                        class="flex items-center justify-between p-4 rounded-xl {{ $buka ? 'bg-green-50' : 'bg-slate-50' }}">
                        <div class="flex items-center gap-3">
                            <div class="size-3 rounded-full {{ $buka ? 'bg-green-500 animate-pulse' : 'bg-slate-300' }}">
                            </div>
                            <span class="text-sm font-bold {{ $buka ? 'text-green-700' : 'text-slate-500' }}">
                                {{ $buka ? 'Pendaftaran Sedang Buka' : 'Pendaftaran Tutup' }}
                            </span>
                        </div>
                    </div>

                    @php
                        $sisaHari = $buka ? now()->diffInDays($ppdb->tanggal_tutup, false) : 0;
                    @endphp
                    @if($buka && $sisaHari > 0)
                        <div class="mt-4 text-center">
                            <p class="text-xs text-slate-500">Sisa hari pendaftaran:</p>
                            <p class="text-2xl font-extrabold text-primary">{{ floor($sisaHari) }} Hari</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Statistik Singkat --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h4 class="font-bold">Statistik Pendaftar</h4>
                </div>
                <div class="p-6 space-y-3">
                    @php
                        $totalPendaftar = $ppdb->pendaftaran()->count();
                        $diterima = $ppdb->pendaftaran()->where('status', 'diterima')->count();
                        $menunggu = $ppdb->pendaftaran()->where('status', 'menunggu_verifikasi')->count();
                    @endphp
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-400">Total Pendaftar</span>
                        <span class="font-bold">{{ $totalPendaftar }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-400">Diterima</span>
                        <span class="font-bold text-green-600">{{ $diterima }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-400">Menunggu Verifikasi</span>
                        <span class="font-bold text-orange-600">{{ $menunggu }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kuota Jurusan --}}
    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-100 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">schema</span>
            <h4 class="font-bold">Kuota Jurusan</h4>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($jurusan as $j)
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                <span
                                    class="material-symbols-outlined text-sm">{{ $iconMap[$j->kode_jurusan] ?? 'school' }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold">{{ $j->kode_jurusan }}</p>
                                <p class="text-[10px] text-slate-400">{{ $j->nama_jurusan }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xs text-slate-500">Kuota:</span>
                            <span class="text-lg font-extrabold text-primary">{{ $j->kuota }}</span>
                        </div>
                        <div class="mt-2">
                            <span class="text-[10px] font-semibold {{ $j->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $j->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection