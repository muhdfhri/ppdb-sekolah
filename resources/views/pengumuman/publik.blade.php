{{-- resources/views/pengumuman/publik.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengumuman PPDB - SMK NU II Medan')

@section('content')

    <div class="drawer drawer-end">
        <input id="mobile-drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex flex-col min-h-screen overflow-x-hidden">

            @include('partials.navbar')

            <main class="flex-1" style="background-color:#F6F4F7;">

                {{-- ══════════════════════════════════════════════════════
                HERO
                ══════════════════════════════════════════════════════ --}}
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                    <div class="relative rounded-3xl overflow-hidden min-h-[260px] flex flex-col justify-end shadow-xl"
                        style="background-color:#018B3E;">
                        <div class="absolute inset-0 z-10"
                            style="background:linear-gradient(to top, rgba(0,0,0,0.78) 0%, rgba(0,0,0,0.15) 60%, transparent 100%);">
                        </div>
                        <div class="absolute inset-0 opacity-35 mix-blend-overlay" style="background-image:url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80');
                                   background-size:cover; background-position:center;"></div>

                        <div class="relative z-20 p-8 md:p-12">
                            <span
                                class="inline-block px-4 py-1.5 rounded-full text-white text-xs font-bold uppercase tracking-wider mb-4"
                                style="background-color:rgba(255,255,255,0.15); backdrop-filter:blur(8px);">
                                Informasi Resmi PPDB
                            </span>
                            <h1 class="text-white text-3xl md:text-4xl font-black leading-tight">
                                Pengumuman &amp; Hasil Seleksi
                            </h1>
                            <p class="text-white/75 mt-2 max-w-xl text-sm">
                                Informasi terbaru seputar PPDB SMK NU II Medan {{ date('Y') }}.
                            </p>

                            {{-- Stats strip --}}
                            <div class="flex flex-wrap items-center gap-6 mt-6">
                                <div>
                                    <p class="text-2xl font-black text-white">{{ $pengumuman->total() }}</p>
                                    <p class="text-xs text-white/55 font-medium">Pengumuman</p>
                                </div>
                                <div class="w-px h-7" style="background-color:rgba(255,255,255,0.2);"></div>
                                <div>
                                    <p class="text-2xl font-black text-white">{{ $pendaftaran->total() }}</p>
                                    <p class="text-xs text-white/55 font-medium">Total Pendaftar</p>
                                </div>
                                <div class="w-px h-7" style="background-color:rgba(255,255,255,0.2);"></div>
                                <div>
                                    <p class="text-2xl font-black" style="color:#F6CB04;">
                                        {{ $pendaftaran->where('status', 'diterima')->count() }}
                                    </p>
                                    <p class="text-xs text-white/55 font-medium">Diterima</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════════
                MAIN CONTENT
                ══════════════════════════════════════════════════════ --}}
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                    <section class="space-y-6">

                        {{-- ── PENGUMUMAN ──────────────────────────────── --}}

                        @if($pengumuman->isEmpty())
                            <div class="bg-white rounded-2xl py-16 text-center border border-slate-200 shadow-sm">
                                <span class="material-symbols-outlined text-5xl text-slate-200 block mb-3">campaign</span>
                                <p class="font-bold text-slate-500 text-sm">Belum ada pengumuman</p>
                                <p class="text-slate-400 text-xs mt-1">Pengumuman akan ditampilkan di sini. Cek kembali nanti.
                                </p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($pengumuman as $p)
                                    @php $tgl = $p->tanggal_publish ?? $p->created_at; @endphp
                                    <article
                                        class="bg-white rounded-2xl border border-slate-200 overflow-hidden transition-all hover:-translate-y-0.5 hover:shadow-lg shadow-sm">
                                        <div class="flex flex-col md:flex-row">
                                            {{-- Date sidebar --}}
                                            <div class="md:w-20 shrink-0 flex md:flex-col items-center justify-center gap-1 p-4 md:p-5"
                                                style="background:linear-gradient(135deg,#018B3E,#016b30);">
                                                <p class="text-2xl font-black text-white leading-none">
                                                    {{ \Carbon\Carbon::parse($tgl)->format('d') }}
                                                </p>
                                                <p class="text-[10px] font-bold text-white/75 uppercase tracking-wider">
                                                    {{ \Carbon\Carbon::parse($tgl)->translatedFormat('M') }}
                                                </p>
                                                <p class="text-[10px] text-white/50">
                                                    {{ \Carbon\Carbon::parse($tgl)->format('Y') }}
                                                </p>
                                            </div>

                                            {{-- Content --}}
                                            <div class="flex-1 p-5 md:p-6">
                                                <div class="flex items-start justify-between gap-4 mb-2">
                                                    <h3 class="text-base font-bold text-slate-900 leading-snug">{{ $p->judul }}</h3>
                                                    @if(\Carbon\Carbon::parse($tgl)->diffInDays(now()) < 7)
                                                        <span
                                                            class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase"
                                                            style="background-color:rgba(246,203,4,0.15); color:#b45309;">
                                                            <span class="size-1.5 rounded-full"
                                                                style="background-color:#F6CB04;"></span>
                                                            Baru
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 mb-4">
                                                    {{ Str::limit(strip_tags($p->isi), 180) }}
                                                </p>
                                                <div class="flex items-center justify-between gap-4">
                                                    <div class="flex items-center gap-4 text-xs text-slate-400">
                                                        @if($p->createdBy)
                                                            <span class="flex items-center gap-1.5">
                                                                <span
                                                                    class="size-5 rounded-full flex items-center justify-center text-white text-[9px] font-bold"
                                                                    style="background-color:#018B3E;">
                                                                    {{ strtoupper(substr($p->createdBy->nama_lengkap ?? $p->createdBy->name, 0, 2)) }}
                                                                </span>
                                                                {{ Str::limit($p->createdBy->nama_lengkap ?? $p->createdBy->name, 20) }}
                                                            </span>
                                                        @endif
                                                        <span class="flex items-center gap-1">
                                                            <span class="material-symbols-outlined text-sm">schedule</span>
                                                            {{ \Carbon\Carbon::parse($tgl)->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                    <a href="{{ route('pengumuman.publik.show', $p->id) }}"
                                                        class="shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition-all"
                                                        style="background-color:rgba(1,139,62,0.08); color:#018B3E;"
                                                        onmouseover="this.style.backgroundColor='rgba(1,139,62,0.15)';"
                                                        onmouseout="this.style.backgroundColor='rgba(1,139,62,0.08)';">
                                                        Baca Selengkapnya
                                                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                            @if($pengumuman->hasPages())
                                <div class="flex justify-center pt-4">{{ $pengumuman->links() }}</div>
                            @endif
                        @endif

                        {{-- ── HASIL SELEKSI ───────────────────────────── --}}

                        {{-- Stats cards --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                            @php
                                $stats = [
                                    ['label' => 'Total Pendaftar', 'count' => $pendaftaran->total(), 'icon' => 'group', 'color' => '#018B3E'],
                                    ['label' => 'Diterima', 'count' => $pendaftaran->where('status', 'diterima')->count(), 'icon' => 'check_circle', 'color' => '#16a34a'],
                                    ['label' => 'Cadangan', 'count' => $pendaftaran->where('status', 'cadangan')->count(), 'icon' => 'pending', 'color' => '#b45309'],
                                    ['label' => 'Menunggu', 'count' => $pendaftaran->where('status', 'menunggu_verifikasi')->count(), 'icon' => 'hourglass_top', 'color' => '#64748b'],
                                ];
                            @endphp
                            @foreach($stats as $s)
                                <div class="bg-white rounded-2xl p-4 flex items-center gap-3 border border-slate-200 shadow-sm">
                                    <div class="size-9 rounded-xl flex items-center justify-center text-white shrink-0"
                                        style="background-color:{{ $s['color'] }};">
                                        <span class="material-symbols-outlined text-sm">{{ $s['icon'] }}</span>
                                    </div>
                                    <div>
                                        <p class="text-xl font-extrabold text-slate-900">{{ $s['count'] }}</p>
                                        <p class="text-[10px] text-slate-500 font-medium leading-tight">{{ $s['label'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Search & Filter --}}
                        <div
                            class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex flex-col md:flex-row gap-3 mb-4">
                            <div class="relative flex-1">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                                <input type="text" id="search-input" placeholder="Cari nama atau nomor pendaftaran..."
                                    class="w-full pl-12 pr-4 py-3 rounded-xl text-sm outline-none transition-all"
                                    style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                    onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.1)';"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                    oninput="filterTable(this.value)">
                            </div>
                            <div class="flex gap-2 flex-wrap">
                                @foreach(['semua' => 'Semua', 'diterima' => 'Diterima', 'cadangan' => 'Cadangan', 'menunggu_verifikasi' => 'Menunggu'] as $val => $label)
                                                        <button onclick="filterStatus('{{ $val }}')" data-filter="{{ $val }}"
                                                            class="filter-btn px-4 py-2 rounded-xl text-xs font-bold border transition-all" style="{{ $val === 'semua'
                                    ? 'background-color:#018B3E; color:white; border-color:#018B3E;'
                                    : 'background-color:white; color:#64748b; border-color:#e2e8f0;' }}">
                                                            {{ $label }}
                                                        </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                                <h3 class="font-bold text-slate-800 text-sm">Daftar Hasil Seleksi</h3>
                                <span class="text-xs text-slate-400">{{ $pendaftaran->total() }} data</span>
                            </div>

                            @if($pendaftaran->isEmpty())
                                <div class="py-16 text-center">
                                    <span class="material-symbols-outlined text-5xl text-slate-200 block mb-3">how_to_reg</span>
                                    <p class="text-slate-500 font-semibold text-sm">Belum ada data seleksi</p>
                                    <p class="text-slate-400 text-xs mt-1">Data akan ditampilkan setelah proses seleksi selesai.
                                    </p>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm" id="seleksi-table">
                                        <thead>
                                            <tr class="border-b border-slate-100" style="background-color:#f8fafc;">
                                                <th
                                                    class="text-left px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    No.</th>
                                                <th
                                                    class="text-left px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    No. Pendaftaran</th>
                                                <th
                                                    class="text-left px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    Nama</th>
                                                <th
                                                    class="text-left px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider hidden md:table-cell">
                                                    Sekolah Asal</th>
                                                <th
                                                    class="text-left px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider hidden sm:table-cell">
                                                    Jurusan</th>
                                                <th
                                                    class="text-left px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                    Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-50" id="seleksi-tbody">
                                            @foreach($pendaftaran as $index => $daftar)
                                                @php
                                                    $sc = match ($daftar->status) {
                                                        'diterima' => ['label' => 'Diterima', 'bg' => 'rgba(22,163,74,0.1)', 'color' => '#16a34a', 'dot' => '#16a34a'],
                                                        'cadangan' => ['label' => 'Cadangan', 'bg' => 'rgba(180,83,9,0.1)', 'color' => '#b45309', 'dot' => '#d97706'],
                                                        'ditolak' => ['label' => 'Ditolak', 'bg' => 'rgba(220,38,38,0.1)', 'color' => '#dc2626', 'dot' => '#ef4444'],
                                                        'menunggu_verifikasi' => ['label' => 'Menunggu', 'bg' => 'rgba(100,116,139,0.1)', 'color' => '#64748b', 'dot' => '#94a3b8'],
                                                        'terverifikasi' => ['label' => 'Terverifikasi', 'bg' => 'rgba(1,139,62,0.1)', 'color' => '#018B3E', 'dot' => '#018B3E'],
                                                        default => ['label' => $daftar->status, 'bg' => 'rgba(100,116,139,0.1)', 'color' => '#64748b', 'dot' => '#94a3b8'],
                                                    };
                                                @endphp
                                                <tr class="hover:bg-slate-50 transition-colors seleksi-row"
                                                    data-status="{{ $daftar->status }}"
                                                    data-search="{{ strtolower(($daftar->siswa->nama_lengkap ?? '') . ' ' . $daftar->nomor_pendaftaran) }}">
                                                    <td class="px-5 py-4 text-slate-400 text-xs font-medium">
                                                        {{ $pendaftaran->firstItem() + $loop->index }}
                                                    </td>
                                                    <td class="px-5 py-4">
                                                        <span
                                                            class="font-mono text-xs font-semibold text-slate-700">{{ $daftar->nomor_pendaftaran }}</span>
                                                    </td>
                                                    <td class="px-5 py-4 font-semibold text-slate-900 text-sm">
                                                        {{ $daftar->siswa->nama_lengkap ?? '—' }}
                                                    </td>
                                                    <td class="px-5 py-4 text-slate-500 text-xs hidden md:table-cell">
                                                        {{ $daftar->sekolahAsal->nama_sekolah ?? '—' }}
                                                    </td>
                                                    <td class="px-5 py-4 text-xs text-slate-600 hidden sm:table-cell">
                                                        {{ $daftar->jurusan->nama_jurusan ?? '—' }}
                                                    </td>
                                                    <td class="px-5 py-4">
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                                                            style="background-color:{{ $sc['bg'] }}; color:{{ $sc['color'] }};">
                                                            <span class="size-1.5 rounded-full shrink-0"
                                                                style="background-color:{{ $sc['dot'] }};"></span>
                                                            {{ $sc['label'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($pendaftaran->hasPages())
                                    <div class="px-6 py-4 border-t border-slate-100">{{ $pendaftaran->links() }}</div>
                                @endif
                            @endif
                        </div>

                        {{-- Info cards --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
                            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm border-l-4"
                                style="border-left-color:#018B3E;">
                                <h5 class="font-bold flex items-center gap-2 mb-2 text-sm" style="color:#018B3E;">
                                    <span class="material-symbols-outlined text-base">info</span>
                                    Informasi Daftar Ulang
                                </h5>
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    Pendaftar yang dinyatakan <strong>Diterima</strong> wajib melakukan daftar ulang sesuai
                                    jadwal yang telah ditentukan dengan membawa berkas asli ke sekretariat PPDB.
                                </p>
                            </div>
                            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm border-l-4"
                                style="border-left-color:#F6CB04;">
                                <h5 class="font-bold flex items-center gap-2 mb-2 text-sm text-slate-800">
                                    <span class="material-symbols-outlined text-base"
                                        style="color:#b45309;">support_agent</span>
                                    Butuh Bantuan?
                                </h5>
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    Jika nama Anda tidak ditemukan atau status tidak sesuai, segera hubungi panitia PPDB
                                    melalui WhatsApp Center.
                                </p>
                                <a href="https://wa.me/6281266857686" target="_blank" rel="noopener noreferrer"
                                    class="mt-3 inline-flex items-center gap-2 text-sm font-bold" style="color:#b45309;">
                                    <span class="material-symbols-outlined text-base">chat</span>WhatsApp Center
                                </a>
                            </div>
                        </div>
                    </section>

                </div>{{-- end main content --}}

                @include('partials.footer')
            </main>
        </div>{{-- end drawer-content --}}

        {{-- ── MOBILE DRAWER ─────────────────────────────────── --}}
        <div class="drawer-side z-[60]">
            <label for="mobile-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="min-h-full w-72 flex flex-col" style="background-color:#0f2318;">

                <div class="flex items-center justify-between px-6 py-5 border-b"
                    style="border-color:rgba(255,255,255,0.08);">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded-full flex items-center justify-center" style="background-color:#018B3E;">
                            <span class="material-symbols-outlined text-white text-xl">school</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white uppercase leading-tight">SMK NU II Medan</p>
                            <p class="text-[10px] opacity-60 text-white">Generasi Unggul &amp; Islami</p>
                        </div>
                    </div>
                    <label for="mobile-drawer" class="btn btn-ghost btn-sm p-1" style="color:rgba(255,255,255,0.6);">
                        <span class="material-symbols-outlined">close</span>
                    </label>
                </div>

                @auth
                    @php
                        $user = Auth::user();
                        $initials = collect(explode(' ', $user->nama_lengkap ?? $user->name))->map(fn($w) => strtoupper($w[0]))->take(2)->join('');
                        $dashboard = $user->isAdmin() ? route('admin.dashboard') : route('siswa.dashboard');
                        $dashLabel = $user->isAdmin() ? 'Panel Admin' : 'Dashboard Saya';
                        $dashIcon = $user->isAdmin() ? 'admin_panel_settings' : 'dashboard';
                    @endphp
                    <div class="mx-4 mt-5 rounded-2xl p-4"
                        style="background-color:rgba(1,139,62,0.2); border:1px solid rgba(1,139,62,0.3);">
                        <div class="flex items-center gap-3">
                            <div class="size-10 rounded-full font-black text-sm flex items-center justify-center shrink-0"
                                style="background-color:#F6CB04; color:#0f2318;">{{ $initials }}</div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-white truncate">{{ $user->nama_lengkap ?? $user->name }}</p>
                                <p class="text-xs truncate" style="color:rgba(246,203,4,0.85);">
                                    {{ $user->isAdmin() ? 'Administrator' : 'Pendaftar' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endauth

                <nav class="flex flex-col px-4 py-4 gap-1 flex-1">
                    @foreach([
                            ['href' => route('home') . '#beranda', 'icon' => 'home', 'label' => 'Beranda'],
                            ['href' => route('home') . '#tentang', 'icon' => 'info', 'label' => 'Tentang'],
                            ['href' => route('home') . '#periode', 'icon' => 'event_note', 'label' => 'Periode PPDB'],
                            ['href' => route('home') . '#alur', 'icon' => 'route', 'label' => 'Alur PPDB'],
                            ['href' => route('home') . '#syarat', 'icon' => 'checklist', 'label' => 'Syarat'],
                            ['href' => route('home') . '#faq', 'icon' => 'help', 'label' => 'FAQ'],
                        ] as $nav)
                        <a href="{{ $nav['href'] }}"
                            onclick="document.getElementById('mobile-drawer').checked = false;"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                            style="color:rgba(255,255,255,0.75);"
                            onmouseover="this.style.backgroundColor='rgba(1,139,62,0.25)';this.style.color='white';"
                            onmouseout="this.style.backgroundColor='transparent';this.style.color='rgba(255,255,255,0.75)';">
                            <span class="material-symbols-outlined text-xl" style="color:#018B3E;">{{ $nav['icon'] }}</span>
                            {{ $nav['label'] }}
                        </a>
                    @endforeach

                    {{-- Pengumuman — active --}}
                    <a href="{{ route('pengumuman.publik') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all"
                        style="color:white; background-color:rgba(1,139,62,0.2);">

                                               <span class="material-symbols-outlined text-xl" style="color:#018B3E;">campaign</span>
                        Pengumuman
                    </a>

                    @auth
                        <div class="mt-3 pt-3 border-t" style="border-color:rgba(255,255,255,0.08);">
                            <p class="text-[10px] font-bold uppercase tracking-widest px-4 mb-2" style="color:rgba(255,255,255,0.35);">Akun Saya</p>
                            <a href="{{ $dashboard }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all"
                                style="color:#F6CB04; background-color:rgba(246,203,4,0.08);"
                                onmouseover="this.style.backgroundColor='rgba(246,203,4,0.16)';"
                                onmouseout="this.style.backgroundColor='rgba(246,203,4,0.08)';">
                                <span class="material-symbols-outlined text-xl" style="color:#F6CB04;">{{ $dashIcon }}</span>
                                {{ $dashLabel }}
                            </a>
                        </div>
                    @endauth
                </nav>

                <div class="px-4 pb-8 pt-2 border-t" style="border-color:rgba(255,255,255,0.08);">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold text-sm transition-all"
                                style="background-color:rgba(239,68,68,0.15); color:#fca5a5; border:1.5px solid rgba(239,68,68,0.25);"
                                onmouseover="this.style.backgroundColor='rgba(239,68,68,0.25)';"
                                onmouseout="this.style.backgroundColor='rgba(239,68,68,0.15)';">
                                <span class="material-symbols-outlined text-xl">logout</span>
                                Keluar dari Akun
                            </button>
                        </form>
                    @else
                        <a href="{{ route('register') }}"
                            class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold text-sm hover:brightness-110 transition-all"
                            style="background-color:#F6CB04; color:#0f2318;">
                            <span class="material-symbols-outlined text-xl">how_to_reg</span>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-bold text-sm mt-3 transition-all"
                            style="border:1.5px solid rgba(1,139,62,0.5); color:rgba(255,255,255,0.75);"
                            onmouseover="this.style.borderColor='#018B3E';this.style.color='white';"
                            onmouseout="this.style.borderColor='rgba(1,139,62,0.5)';this.style.color='rgba(255,255,255,0.75)';">
                            <span class="material-symbols-outlined text-xl">login</span>
                            Login
                        </a>
                    @endauth
                </div>

            </div>
        </div>

    </div>{{-- end drawer --}}

    @push('scripts')
        <script>
            function filterStatus(status) {
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    if (btn.dataset.filter === status) {
                        btn.style.backgroundColor = '#018B3E';
                        btn.style.color = 'white';
                        btn.style.borderColor = '#018B3E';
                    } else {
                        btn.style.backgroundColor = 'white';
                        btn.style.color = '#64748b';
                        btn.style.borderColor = '#e2e8f0';
                    }
                });
                const q = document.getElementById('search-input')?.value.toLowerCase() ?? '';
                document.querySelectorAll('.seleksi-row').forEach(row => {
                    const statusMatch = status === 'semua' || row.dataset.status === status;
                    const searchMatch = !q || row.dataset.search.includes(q);
                    row.style.display = statusMatch && searchMatch ? '' : 'none';
                });
            }

            function filterTable(query) {
                const q = query.toLowerCase();
                const activeBtn = document.querySelector('.filter-btn[style*="background-color: rgb(1"]');
                const activeFilter = activeBtn?.dataset.filter ?? 'semua';
                document.querySelectorAll('.seleksi-row').forEach(row => {
                    const statusMatch = activeFilter === 'semua' || row.dataset.status === activeFilter;
                    const searchMatch = !q || row.dataset.search.includes(q);
                    row.style.display = statusMatch && searchMatch ? '' : 'none';
                });
            }
        </script>
    @endpush

@endsection