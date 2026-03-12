{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    {{-- ── Welcome Section ─────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Dashboard Overview</h2>
            <p class="text-slate-500 mt-1">Sistem Penerimaan Peserta Didik Baru (PPDB)</p>
        </div>
        <div class="flex gap-2">
            <div
                class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm font-semibold bg-white dark:bg-slate-900">
                <span class="material-symbols-outlined text-lg text-slate-400">calendar_today</span>
                <span>{{ now()->translatedFormat('d M Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ── Stats Grid ───────────────────────────────────────── --}}
    @php
        $growth = $stats['growth'] ?? 0;
        $growthPositive = $growth >= 0;
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Total Pendaftar --}}
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex justify-between items-start">
                <div
                    class="size-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                    <span class="material-symbols-outlined text-3xl">groups</span>
                </div>
                {{-- Growth badge: warna dinamis berdasarkan nilai growth --}}
                <span class="text-xs font-bold px-2 py-1 rounded-md
                            {{ $growthPositive
        ? 'text-green-600 bg-green-50 dark:bg-green-900/20'
        : 'text-red-500 bg-red-50 dark:bg-red-900/20' }}">
                    {{ $growthPositive ? '+' : '' }}{{ $growth }}%
                </span>
            </div>
            <p class="mt-4 text-slate-500 text-sm font-medium">Total Pendaftar</p>
            <h3 class="text-2xl font-bold mt-1">{{ number_format($stats['total'] ?? 0) }}</h3>
            <p class="text-xs text-slate-400 mt-1">vs. bulan lalu</p>
        </div>

        {{-- Diterima --}}
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex justify-between items-start">
                <div
                    class="size-12 rounded-xl bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-600">
                    <span class="material-symbols-outlined text-3xl">check_circle</span>
                </div>
                @php
                    $pctDiterima = ($stats['total'] ?? 0) > 0
                        ? round(($stats['diterima'] / $stats['total']) * 100)
                        : 0;
                @endphp
                <span class="text-xs font-bold text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-md">
                    {{ $pctDiterima }}%
                </span>
            </div>
            <p class="mt-4 text-slate-500 text-sm font-medium">Diterima</p>
            <h3 class="text-2xl font-bold mt-1">{{ number_format($stats['diterima'] ?? 0) }}</h3>
            <p class="text-xs text-slate-400 mt-1">dari total pendaftar</p>
        </div>

        {{-- Ditolak --}}
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex justify-between items-start">
                <div class="size-12 rounded-xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600">
                    <span class="material-symbols-outlined text-3xl">cancel</span>
                </div>
                @php
                    $pctDitolak = ($stats['total'] ?? 0) > 0
                        ? round(($stats['ditolak'] / $stats['total']) * 100)
                        : 0;
                @endphp
                <span class="text-xs font-bold text-red-500 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-md">
                    {{ $pctDitolak }}%
                </span>
            </div>
            <p class="mt-4 text-slate-500 text-sm font-medium">Ditolak</p>
            <h3 class="text-2xl font-bold mt-1">{{ number_format($stats['ditolak'] ?? 0) }}</h3>
            <p class="text-xs text-slate-400 mt-1">dari total pendaftar</p>
        </div>

        {{-- Menunggu Verifikasi --}}
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex justify-between items-start">
                <div
                    class="size-12 rounded-xl bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-600">
                    <span class="material-symbols-outlined text-3xl">pending_actions</span>
                </div>
                @php
                    $pctMenunggu = ($stats['total'] ?? 0) > 0
                        ? round(($stats['menunggu'] / $stats['total']) * 100)
                        : 0;
                @endphp
                <span class="text-xs font-bold text-orange-500 bg-orange-50 dark:bg-orange-900/20 px-2 py-1 rounded-md">
                    {{ $pctMenunggu }}%
                </span>
            </div>
            <p class="mt-4 text-slate-500 text-sm font-medium">Menunggu Verifikasi</p>
            <h3 class="text-2xl font-bold mt-1">{{ number_format($stats['menunggu'] ?? 0) }}</h3>
            <p class="text-xs text-slate-400 mt-1">perlu ditindaklanjuti</p>
        </div>
    </div>

    {{-- ── Tren & Aktivitas ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Tren Mingguan — pakai $trenMingguan dari controller --}}
        <div
            class="lg:col-span-2 bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold">Tren Pendaftaran Mingguan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ now()->translatedFormat('F Y') }}</p>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 bg-primary/5 rounded-lg">
                    <span class="size-2 rounded-full bg-primary"></span>
                    <span class="text-xs font-semibold text-primary">Minggu ini</span>
                </div>
            </div>

            @php
                $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                $daysLong = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                // $trenMingguan dari controller: array 7 elemen [senin..minggu]
                $tren = $trenMingguan ?? [0, 0, 0, 0, 0, 0, 0];
                $maxTren = max(array_merge($tren, [1])); // hindari div/0
                $today = now()->dayOfWeekIso - 1;      // 0=Senin, 6=Minggu
            @endphp

            {{-- Bar chart --}}
            <div class="flex items-end justify-between gap-3 px-2" style="height: 180px;">
                @foreach($tren as $i => $val)
                    @php
                        $heightPct = $maxTren > 0 ? round(($val / $maxTren) * 100) : 0;
                        $heightPct = max($heightPct, 4); // minimal bar kecil tetap terlihat
                        $isToday = ($i === $today);
                    @endphp
                    <div class="flex flex-col items-center flex-1 gap-2 h-full justify-end group">
                        {{-- Tooltip nilai --}}
                        <span class="text-[10px] font-bold text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ $val }}
                        </span>
                        {{-- Bar --}}
                        <div class="w-full rounded-t-lg transition-all duration-300" style="height: {{ $heightPct }}%;
                                                   background-color: {{ $isToday ? '#01893e' : 'rgba(1,137,62,0.2)' }};
                                                   min-height: 4px;">
                        </div>
                        {{-- Label hari --}}
                        <span class="text-[10px] font-bold {{ $isToday ? 'text-primary' : 'text-slate-400' }}">
                            {{ $days[$i] }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div
                class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-sm">
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2">
                        <div class="size-3 rounded-full bg-primary"></div>
                        <span class="text-slate-500 font-medium text-xs">Hari ini</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="size-3 rounded-full bg-primary/20"></div>
                        <span class="text-slate-500 font-medium text-xs">Hari lain</span>
                    </div>
                </div>
                <p class="font-bold text-primary text-sm">
                    Avg: {{ $stats['avg_per_day'] ?? 0 }}/hari
                </p>
            </div>
        </div>

        {{-- Aktivitas Terakhir --}}
        <div class="bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <h3 class="text-lg font-bold mb-6">Aktivitas Terakhir</h3>

            @php
                // Icon mapping berdasarkan status verifikasi log
                $logIconMap = [
                    'diterima' => ['icon' => 'check_circle', 'color' => '#16a34a', 'bg' => 'rgba(22,163,74,0.1)'],
                    'ditolak' => ['icon' => 'cancel', 'color' => '#dc2626', 'bg' => 'rgba(220,38,38,0.1)'],
                    'menunggu_verifikasi' => ['icon' => 'pending_actions', 'color' => '#d97706', 'bg' => 'rgba(217,119,6,0.1)'],
                    'terverifikasi' => ['icon' => 'verified', 'color' => '#01893e', 'bg' => 'rgba(1,137,62,0.1)'],
                    'cadangan' => ['icon' => 'bookmark', 'color' => '#7c3aed', 'bg' => 'rgba(124,58,237,0.1)'],
                ];
                $defaultLog = ['icon' => 'upload_file', 'color' => '#01893e', 'bg' => 'rgba(1,137,62,0.1)'];
            @endphp

            <div class="space-y-5">
                @forelse($aktivitas ?? [] as $log)
                    @php
                        $lc = $logIconMap[$log->status_sesudah] ?? $defaultLog;
                    @endphp
                    <div class="flex gap-4">
                        <div class="relative shrink-0">
                            <div class="size-10 rounded-full flex items-center justify-center z-10 relative"
                                style="background-color: {{ $lc['bg'] }}; color: {{ $lc['color'] }};">
                                <span class="material-symbols-outlined text-xl">{{ $lc['icon'] }}</span>
                            </div>
                            @if(!$loop->last)
                                <div class="absolute top-10 left-1/2 -translate-x-1/2 w-0.5 h-5 bg-slate-100 dark:bg-slate-800">
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold capitalize">
                                {{ str_replace('_', ' ', $log->status_sesudah) }}
                            </p>
                            <p class="text-xs text-slate-500 truncate">
                                {{ $log->pendaftaran->siswa->nama_lengkap ?? '—' }}
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <p class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</p>
                                @if($log->admin)
                                    <span class="text-[10px] text-slate-300">·</span>
                                    <p class="text-[10px] text-slate-400 truncate">
                                        oleh {{ Str::limit($log->admin->nama_lengkap ?? $log->admin->name, 16) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- State kosong --}}
                    <div class="py-8 text-center">
                        <span class="material-symbols-outlined text-4xl text-slate-200 block mb-2">history</span>
                        <p class="text-sm font-semibold text-slate-400">Belum ada aktivitas</p>
                        <p class="text-xs text-slate-300 mt-1">Log aktivitas akan muncul di sini</p>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('admin.pendaftar.index') }}"
                class="block w-full mt-8 py-3 text-sm font-bold text-center text-slate-500 border border-slate-200 dark:border-slate-800 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                Lihat Semua Log
            </a>
        </div>
    </div>

    {{-- ── Pendaftar Terbaru ────────────────────────────────── --}}
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="font-bold">Pendaftar Terbaru</h3>
            <a href="{{ route('admin.pendaftar.index') }}"
                class="text-xs text-primary font-semibold hover:underline flex items-center gap-1">
                Lihat Semua
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800">
                        <th class="text-left px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Sekolah
                            Asal</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Jurusan
                        </th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal
                            Daftar</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($pendaftaranTerbaru ?? [] as $p)
                        @php
                            $statusCfg = [
                                'draft' => ['label' => 'Draft', 'bg' => 'rgba(100,116,139,0.1)', 'color' => '#64748b'],
                                'menunggu_pembayaran' => ['label' => 'Pembayaran', 'bg' => 'rgba(217,119,6,0.1)', 'color' => '#d97706'],
                                'menunggu_verifikasi' => ['label' => 'Verifikasi', 'bg' => 'rgba(217,119,6,0.1)', 'color' => '#d97706'],
                                'terverifikasi' => ['label' => 'Terverifikasi', 'bg' => 'rgba(1,137,62,0.1)', 'color' => '#01893e'],
                                'diterima' => ['label' => 'Diterima', 'bg' => 'rgba(22,163,74,0.1)', 'color' => '#16a34a'],
                                'ditolak' => ['label' => 'Ditolak', 'bg' => 'rgba(220,38,38,0.1)', 'color' => '#dc2626'],
                                'cadangan' => ['label' => 'Cadangan', 'bg' => 'rgba(124,58,237,0.1)', 'color' => '#7c3aed'],
                            ];
                            $sc = $statusCfg[$p->status] ?? ['label' => $p->status, 'bg' => 'rgba(100,116,139,0.1)', 'color' => '#64748b'];
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                        style="background-color: #01893e;">
                                        {{ strtoupper(substr($p->siswa->nama_lengkap ?? '?', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900 dark:text-white">
                                            {{ $p->siswa->nama_lengkap ?? '—' }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-mono">{{ $p->nomor_pendaftaran }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">
                                {{ $p->sekolahAsal->nama_sekolah ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-600 font-semibold">
                                {{ $p->jurusan->kode_jurusan ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($p->tanggal_daftar ?? $p->created_at)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                                    style="background-color: {{ $sc['bg'] }}; color: {{ $sc['color'] }};">
                                    <span class="size-1.5 rounded-full shrink-0"
                                        style="background-color: {{ $sc['color'] }};"></span>
                                    {{ $sc['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl block mb-2">person_search</span>
                                <p class="text-sm font-semibold">Belum ada pendaftar</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection