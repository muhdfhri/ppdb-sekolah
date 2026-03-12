{{-- resources/views/pengumuman/publik.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengumuman PPDB - SMK NU II Medan')

@section('content')
    <div class="relative flex min-h-screen flex-col overflow-x-hidden">
        @include('partials.navbar')

        <main class="flex-1" style="background-color: #F6F4F7;">

            {{-- ================================================================
            HERO SECTION (DI-PERTAHANKAN)
            ================================================================ --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                <div class="relative rounded-3xl overflow-hidden min-h-[280px] flex flex-col justify-end shadow-2xl"
                    style="background-color: #018B3E;">

                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 z-10"
                        style="background: linear-gradient(to top, rgba(0,0,0,0.82) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);">
                    </div>

                    {{-- Background image --}}
                    <div class="absolute inset-0 opacity-40 mix-blend-overlay" style="background-image: url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80');
                               background-size: cover; background-position: center;"></div>

                    {{-- Content --}}
                    <div class="relative z-20 p-8 md:p-12">
                        <span
                            class="inline-block px-4 py-1.5 rounded-full text-white text-xs font-bold uppercase tracking-wider mb-4"
                            style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(8px);">
                            Pengumuman Resmi
                        </span>
                        <h1 class="text-white text-3xl md:text-5xl font-black leading-tight">
                            Hasil Seleksi PPDB {{ date('Y') }}
                        </h1>
                        <p class="text-white/80 mt-2 max-w-xl text-sm md:text-base">
                            Selamat kepada calon siswa yang telah lolos seleksi. Silakan lakukan pendaftaran ulang sesuai
                            jadwal
                            yang ditentukan.
                        </p>

                        {{-- Stats row --}}
                        <div class="flex flex-wrap items-center gap-6 mt-6">
                            <div>
                                <p class="text-2xl font-black text-white">{{ $pengumuman->total() }}</p>
                                <p class="text-xs text-white/60 font-medium">Pengumuman</p>
                            </div>
                            <div class="w-px h-8" style="background-color: rgba(255,255,255,0.25);"></div>
                            <div>
                                <p class="text-2xl font-black text-white">{{ $pendaftaran->total() }}</p>
                                <p class="text-xs text-white/60 font-medium">Total Pendaftar</p>
                            </div>
                            <div class="w-px h-8" style="background-color: rgba(255,255,255,0.25);"></div>
                            <div>
                                <p class="text-2xl font-black" style="color: #F6CB04;">
                                    {{ $pendaftaran->where('status', 'diterima')->count() }}
                                </p>
                                <p class="text-xs text-white/60 font-medium">Diterima</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================
            TAB NAVIGATION (SEDERHANA, TANPA BACKGROUND)
            ================================================================ --}}
            <div class="border-b border-slate-200 mt-6" style="background-color: white;">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex overflow-x-auto scrollbar-hide gap-6 md:gap-8">
                        <button onclick="switchTab('pengumuman')" id="tab-pengumuman"
                            class="tab-btn py-4 text-sm font-medium border-b-2 transition-all whitespace-nowrap"
                            style="border-color: #018B3E; color: #018B3E;">
                            Pengumuman
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-bold"
                                style="background-color: rgba(1,139,62,0.1); color: #018B3E;">
                                {{ $pengumuman->total() }}
                            </span>
                        </button>
                        <button onclick="switchTab('seleksi')" id="tab-seleksi"
                            class="tab-btn py-4 text-sm font-medium border-b-2 transition-all whitespace-nowrap"
                            style="border-color: transparent; color: #64748b;">
                            Hasil Seleksi
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-bold"
                                style="background-color: #f1f5f9; color: #64748b;">
                                {{ $pendaftaran->total() }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ================================================================
            CONTENT AREA
            ================================================================ --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

                {{-- TAB 1: PENGUMUMAN --}}
                <div id="panel-pengumuman" class="space-y-8">

                    @if($pengumuman->isEmpty())
                        <div class="bg-white rounded-2xl py-20 text-center border border-slate-200"
                            style="box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                            <span class="material-symbols-outlined text-6xl text-slate-300 block mb-4">campaign</span>
                            <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Pengumuman</h3>
                            <p class="text-slate-400 text-sm">Pengumuman akan ditampilkan di sini. Silakan cek kembali nanti.
                            </p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($pengumuman as $p)
                                <article
                                    class="bg-white rounded-2xl border border-slate-200 overflow-hidden transition-all hover:-translate-y-0.5 hover:shadow-lg"
                                    style="box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                                    <div class="flex flex-col md:flex-row">

                                        {{-- Tanggal sidebar --}}
                                        <div class="md:w-24 shrink-0 flex md:flex-col items-center justify-center gap-2 p-4 md:p-6"
                                            style="background: linear-gradient(135deg, #018B3E, #016b30);">
                                            @php $tgl = $p->tanggal_publish ?? $p->created_at; @endphp
                                            <p class="text-3xl font-black text-white leading-none">
                                                {{ \Carbon\Carbon::parse($tgl)->format('d') }}
                                            </p>
                                            <p class="text-xs font-bold text-white/80 uppercase tracking-widest">
                                                {{ \Carbon\Carbon::parse($tgl)->translatedFormat('M') }}
                                            </p>
                                            <p class="text-xs text-white/60">{{ \Carbon\Carbon::parse($tgl)->format('Y') }}</p>
                                        </div>

                                        {{-- Konten --}}
                                        <div class="flex-1 p-5 md:p-6">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <h2 class="text-base md:text-lg font-bold text-slate-900 leading-snug">
                                                    {{ $p->judul }}
                                                </h2>
                                                @if(\Carbon\Carbon::parse($p->tanggal_publish ?? $p->created_at)->diffInDays(now()) < 7)
                                                    <span
                                                        class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase"
                                                        style="background-color: rgba(246,203,4,0.15); color: #b45309;">
                                                        <span class="size-1.5 rounded-full" style="background-color: #F6CB04;"></span>
                                                        Baru
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 mb-4">
                                                {{ Str::limit(strip_tags($p->isi), 180) }}
                                            </p>

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-4 text-xs text-slate-400">
                                                    @if($p->createdBy)
                                                        <span class="flex items-center gap-1.5">
                                                            <span
                                                                class="size-5 rounded-full flex items-center justify-center text-white text-[9px] font-bold shrink-0"
                                                                style="background-color: #018B3E;">
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
                                                    class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition-all"
                                                    style="background-color: rgba(1,139,62,0.08); color: #018B3E;"
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
                            <div class="flex justify-center pt-4">
                                {{ $pengumuman->links() }}
                            </div>
                        @endif
                    @endif

                </div>

                {{-- TAB 2: HASIL SELEKSI --}}
                <div id="panel-seleksi" class="space-y-6 hidden">

                    {{-- Search + Filter --}}
                    <div class="bg-white rounded-2xl p-5 border border-slate-200 flex flex-col md:flex-row gap-4"
                        style="box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                        <div class="relative flex-1">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                            <input type="text" id="search-input" placeholder="Cari nama atau nomor pendaftaran..."
                                class="w-full pl-12 pr-4 py-3 rounded-xl text-sm border border-slate-200 bg-slate-50 outline-none transition-all"
                                style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                oninput="filterTable(this.value)">
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            @foreach(['semua' => 'Semua', 'diterima' => 'Diterima', 'cadangan' => 'Cadangan', 'menunggu_verifikasi' => 'Menunggu'] as $val => $label)
                                <button onclick="filterStatus('{{ $val }}')" data-filter="{{ $val }}"
                                    class="filter-btn px-4 py-2 rounded-xl text-xs font-bold transition-all border"
                                    style="{{ $val === 'semua' ? 'background-color:#018B3E; color:white; border-color:#018B3E;' : 'background-color:white; color:#64748b; border-color:#e2e8f0;' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Stats row --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @php
                            $statuses = [
                                ['label' => 'Total Pendaftar', 'count' => $pendaftaran->total(), 'icon' => 'group', 'color' => '#018B3E'],
                                ['label' => 'Diterima', 'count' => $pendaftaran->where('status', 'diterima')->count(), 'icon' => 'check_circle', 'color' => '#16a34a'],
                                ['label' => 'Cadangan', 'count' => $pendaftaran->where('status', 'cadangan')->count(), 'icon' => 'pending', 'color' => '#b45309'],
                                ['label' => 'Menunggu', 'count' => $pendaftaran->where('status', 'menunggu_verifikasi')->count(), 'icon' => 'hourglass_top', 'color' => '#64748b'],
                            ];
                        @endphp
                        @foreach($statuses as $stat)
                            <div class="bg-white rounded-2xl p-4 flex items-center gap-3 border border-slate-200"
                                style="box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                                <div class="size-9 rounded-xl flex items-center justify-center text-white shrink-0"
                                    style="background-color: {{ $stat['color'] }};">
                                    <span class="material-symbols-outlined text-sm">{{ $stat['icon'] }}</span>
                                </div>
                                <div>
                                    <p class="text-xl font-extrabold text-slate-900">{{ $stat['count'] }}</p>
                                    <p class="text-[10px] text-slate-500 font-medium leading-tight">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Tabel hasil seleksi --}}
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden"
                        style="box-shadow: 0 4px 20px rgba(0,0,0,0.04);">

                        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                            <h3 class="font-bold text-slate-800 text-sm">Daftar Hasil Seleksi</h3>
                            <span class="text-xs text-slate-400">{{ $pendaftaran->total() }} pendaftar</span>
                        </div>

                        @if($pendaftaran->isEmpty())
                            <div class="py-16 text-center">
                                <span class="material-symbols-outlined text-5xl text-slate-300 block mb-3">how_to_reg</span>
                                <p class="text-slate-500 font-semibold text-sm">Belum ada data seleksi</p>
                                <p class="text-slate-400 text-xs mt-1">Data akan ditampilkan setelah proses seleksi selesai.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm" id="seleksi-table">
                                    <thead>
                                        <tr class="border-b border-slate-200">
                                            <th
                                                class="text-left px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                                No.</th>
                                            <th
                                                class="text-left px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                                No. Pendaftaran</th>
                                            <th
                                                class="text-left px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                                Nama</th>
                                            <th
                                                class="text-left px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                                Sekolah Asal</th>
                                            <th
                                                class="text-left px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                                Jurusan</th>
                                            <th
                                                class="text-left px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100" id="seleksi-tbody">
                                        @foreach($pendaftaran as $index => $daftar)
                                            @php
                                                $statusConfig = [
                                                    'diterima' => ['label' => 'Diterima', 'bg' => 'rgba(22,163,74,0.1)', 'color' => '#16a34a', 'dot' => '#16a34a'],
                                                    'cadangan' => ['label' => 'Cadangan', 'bg' => 'rgba(180,83,9,0.1)', 'color' => '#b45309', 'dot' => '#d97706'],
                                                    'ditolak' => ['label' => 'Ditolak', 'bg' => 'rgba(220,38,38,0.1)', 'color' => '#dc2626', 'dot' => '#ef4444'],
                                                    'menunggu_verifikasi' => ['label' => 'Menunggu', 'bg' => 'rgba(100,116,139,0.1)', 'color' => '#64748b', 'dot' => '#94a3b8'],
                                                    'terverifikasi' => ['label' => 'Terverifikasi', 'bg' => 'rgba(1,139,62,0.1)', 'color' => '#018B3E', 'dot' => '#018B3E'],
                                                ];
                                                $sc = $statusConfig[$daftar->status] ?? ['label' => $daftar->status, 'bg' => 'rgba(100,116,139,0.1)', 'color' => '#64748b', 'dot' => '#94a3b8'];
                                            @endphp
                                            <tr class="hover:bg-slate-50 transition-colors seleksi-row"
                                                data-status="{{ $daftar->status }}"
                                                data-search="{{ strtolower(($daftar->siswa->nama_lengkap ?? '') . ' ' . $daftar->nomor_pendaftaran) }}">
                                                <td class="px-5 py-4 text-slate-400 font-medium text-xs">
                                                    {{ $pendaftaran->firstItem() + $loop->index }}
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="font-mono text-xs font-semibold text-slate-700">
                                                        {{ $daftar->nomor_pendaftaran }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 font-semibold text-slate-900">
                                                    {{ $daftar->siswa->nama_lengkap ?? '—' }}
                                                </td>
                                                <td class="px-5 py-4 text-slate-500 text-xs">
                                                    {{ $daftar->sekolahAsal->nama_sekolah ?? '—' }}
                                                </td>
                                                <td class="px-5 py-4 text-xs text-slate-600">
                                                    {{ $daftar->jurusan->nama_jurusan ?? 'Belum dipilih' }}
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span
                                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold"
                                                        style="background-color: {{ $sc['bg'] }}; color: {{ $sc['color'] }};">
                                                        <span class="size-1.5 rounded-full shrink-0"
                                                            style="background-color: {{ $sc['dot'] }};"></span>
                                                        {{ $sc['label'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($pendaftaran->hasPages())
                                <div class="px-6 py-4 border-t border-slate-200">
                                    {{ $pendaftaran->links() }}
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Info daftar ulang --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-2xl p-6 border-l-4 border border-slate-200"
                            style="border-left-color: #018B3E; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                            <h5 class="font-bold flex items-center gap-2 mb-3" style="color: #018B3E;">
                                <span class="material-symbols-outlined text-base">info</span>
                                Informasi Daftar Ulang
                            </h5>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Calon siswa yang dinyatakan <strong>Diterima</strong> wajib melakukan daftar ulang sesuai
                                jadwal
                                yang telah ditentukan dengan membawa berkas asli ke sekretariat PPDB.
                            </p>
                        </div>
                        <div class="bg-white rounded-2xl p-6 border-l-4 border border-slate-200"
                            style="border-left-color: #F6CB04; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                            <h5 class="font-bold flex items-center gap-2 mb-3 text-slate-800">
                                <span class="material-symbols-outlined text-base"
                                    style="color: #b45309;">support_agent</span>
                                Butuh Bantuan?
                            </h5>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Jika nama Anda tidak ditemukan atau status tidak sesuai, segera hubungi panitia PPDB melalui
                                WhatsApp Center.
                            </p>
                            <a href="#" class="mt-3 inline-flex items-center gap-2 text-sm font-bold"
                                style="color: #b45309;">
                                <span class="material-symbols-outlined text-base">chat</span>WhatsApp Center
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </main>

        @include('partials.footer')
    </div>

    @push('scripts')
        <script>
            // Tab switching
            function switchTab(tab) {
                const panels = { pengumuman: 'panel-pengumuman', seleksi: 'panel-seleksi' };
                const tabs = { pengumuman: 'tab-pengumuman', seleksi: 'tab-seleksi' };

                // Hide all panels
                Object.values(panels).forEach(id => {
                    document.getElementById(id).classList.add('hidden');
                });

                // Reset all tab styles (hanya border-bottom dan warna)
                Object.values(tabs).forEach(id => {
                    const el = document.getElementById(id);
                    el.style.borderColor = 'transparent';
                    el.style.color = '#64748b';

                    // Reset badge
                    const badge = el.querySelector('span:last-child');
                    if (badge) {
                        if (id === 'tab-pengumuman') {
                            badge.style.backgroundColor = '#f1f5f9';
                            badge.style.color = '#64748b';
                        } else {
                            badge.style.backgroundColor = '#f1f5f9';
                            badge.style.color = '#64748b';
                        }
                    }
                });

                // Show selected panel
                document.getElementById(panels[tab]).classList.remove('hidden');

                // Activate selected tab (hanya border-bottom dan warna)
                const activeTab = document.getElementById(tabs[tab]);
                activeTab.style.borderColor = '#018B3E';
                activeTab.style.color = '#018B3E';

                const activeBadge = activeTab.querySelector('span:last-child');
                if (activeBadge) {
                    activeBadge.style.backgroundColor = 'rgba(1,139,62,0.1)';
                    activeBadge.style.color = '#018B3E';
                }

                // Update URL hash
                history.replaceState(null, '', '#' + tab);

                // Scroll active tab into view untuk mobile
                if (window.innerWidth < 768) {
                    activeTab.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest',
                        inline: 'center'
                    });
                }
            }

            // Filter status tabel seleksi
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

                const searchVal = document.getElementById('search-input')?.value.toLowerCase() ?? '';
                document.querySelectorAll('.seleksi-row').forEach(row => {
                    const matchStatus = status === 'semua' || row.dataset.status === status;
                    const matchSearch = !searchVal || row.dataset.search.includes(searchVal);
                    row.style.display = matchStatus && matchSearch ? '' : 'none';
                });
            }

            // Search filter
            function filterTable(query) {
                const q = query.toLowerCase();
                const activeFilter = document.querySelector('.filter-btn[style*="background-color: rgb(1"]')?.dataset.filter ?? 'semua';

                document.querySelectorAll('.seleksi-row').forEach(row => {
                    const matchSearch = !q || row.dataset.search.includes(q);
                    const matchStatus = activeFilter === 'semua' || row.dataset.status === activeFilter;
                    row.style.display = matchSearch && matchStatus ? '' : 'none';
                });
            }

            // Initialize tabs based on URL hash
            document.addEventListener('DOMContentLoaded', function () {
                const hash = window.location.hash.replace('#', '');
                if (hash === 'seleksi') {
                    switchTab('seleksi');
                } else {
                    switchTab('pengumuman');
                }
            });
        </script>
    @endpush

    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Tab transition */
        .tab-btn {
            transition: all 0.2s ease;
        }
    </style>

@endsection