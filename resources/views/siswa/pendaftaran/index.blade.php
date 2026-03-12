{{-- resources/views/siswa/pendaftaran/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pendaftaran Siswa - PPDB SMK NU II Medan')

@section('content')
    <div class="min-h-screen bg-[#F6F4F7] font-['Public Sans']">

        {{-- ================================================================
        MOBILE HEADER
        ================================================================ --}}
        <div
            class="lg:hidden bg-white sticky top-0 z-50 px-4 py-3 flex items-center justify-between border-b border-slate-200">
            <div class="flex items-center gap-2">
                <button type="button" id="mobile-menu-button" class="p-2 rounded-lg hover:bg-slate-100">
                    <span class="material-symbols-outlined text-slate-600">menu</span>
                </button>
            </div>
            <div class="flex items-center gap-3">
                <!-- <button class="relative p-2">
                                <span class="material-symbols-outlined text-slate-600">notifications</span>
                                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button> -->
                <div
                    class="w-8 h-8 rounded-full bg-[#018B3E]/10 border-2 border-[#018B3E]/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm text-[#018B3E]">person</span>
                </div>
            </div>
        </div>

        {{-- ================================================================
        MOBILE SIDEBAR (sama dengan dashboard)
        =============================================================== --}}
        <div id="mobile-sidebar" class="hidden fixed inset-0 z-50 lg:hidden">
            <div class="absolute inset-0 bg-black/50" onclick="toggleMobileSidebar()"></div>
            <aside class="absolute left-0 top-0 h-full w-72 bg-white flex flex-col p-6 shadow-xl">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0">
                            <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h1 class="font-bold text-sm leading-tight text-[#018B3E]">SMK NU II<br />Medan</h1>
                            <p class="text-xs text-slate-500">Portal PPDB</p>
                        </div>
                    </div>
                    <button onclick="toggleMobileSidebar()" class="p-2 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <nav class="flex flex-col gap-2 flex-1">
                    <a href="{{ route('siswa.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-[#018B3E]/5">
                        <span class="material-symbols-outlined">home</span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('siswa.pendaftaran.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-white bg-[#018B3E]">
                        <span class="material-symbols-outlined">assignment</span>
                        <span class="font-medium">Pendaftaran</span>
                    </a>
                    <div class="mt-4 pt-4 border-t border-slate-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50">
                                <span class="material-symbols-outlined">logout</span>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>

                {{-- Tombol Cetak Bukti - DIPERBAIKI --}}
                @if(isset($pendaftaran) && $pendaftaran && $pendaftaran->status !== 'draft')
                    <a href="{{ route('siswa.pendaftaran.cetak') }}"
                        class="w-full bg-[#F6CB04] text-[#0f2318] font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 hover:brightness-95 mt-4">
                        <span class="material-symbols-outlined">print</span>
                        <span>Cetak Bukti</span>
                    </a>
                @else
                    <div
                        class="w-full bg-slate-100 text-slate-400 font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed mt-4">
                        <span class="material-symbols-outlined">print</span>
                        <span>Cetak Bukti</span>
                    </div>
                @endif
            </aside>
        </div>

        {{-- ================================================================
        DESKTOP SIDEBAR
        =============================================================== --}}
        <aside class="hidden lg:flex fixed top-0 left-0 w-72 h-screen bg-white flex-col justify-between p-6 z-40"
            style="border-right: 1px solid rgba(1,139,62,0.1);">
            <div class="flex flex-col gap-8">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0">
                        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
                            class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="font-bold text-sm leading-tight text-[#018B3E]">SMK NU II<br />Medan</h1>
                        <p class="text-xs text-slate-500">Portal PPDB</p>
                    </div>
                </div>
                <nav class="flex flex-col gap-2">
                    <a href="{{ route('siswa.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-[#018B3E]/5">
                        <span class="material-symbols-outlined">home</span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('siswa.pendaftaran.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-white bg-[#018B3E]">
                        <span class="material-symbols-outlined">assignment</span>
                        <span class="font-medium">Pendaftaran</span>
                    </a>
                    <div class="mt-4 pt-4 border-t border-slate-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50">
                                <span class="material-symbols-outlined">logout</span>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

            {{-- Tombol Cetak Bukti - DIPERBAIKI --}}
            @if(isset($pendaftaran) && $pendaftaran && $pendaftaran->status !== 'draft')
                <a href="{{ route('siswa.pendaftaran.cetak') }}"
                    class="w-full bg-[#F6CB04] text-[#0f2318] font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 hover:brightness-95">
                    <span class="material-symbols-outlined">print</span>
                    <span>Cetak Bukti</span>
                </a>
            @else
                <div
                    class="w-full bg-slate-100 text-slate-400 font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed">
                    <span class="material-symbols-outlined">print</span>
                    <span>Cetak Bukti</span>
                </div>
            @endif
        </aside>
        {{-- ================================================================
        MAIN CONTENT (flexible width)
        ================================================================ --}}
        <main class="lg:ml-72 min-h-screen flex flex-col">
            {{-- Desktop Header (hidden di mobile) --}}
            <header class="hidden lg:flex h-20 bg-white px-8 items-center justify-between"
                style="border-bottom: 1px solid #f1f5f9;">
                <div class="flex items-center gap-2">
                    <span class="text-slate-400 font-medium">Pendaftaran</span>
                    <span class="material-symbols-outlined text-slate-300">chevron_right</span>
                    <span class="font-semibold text-[#018B3E]">
                        @if($pendaftaran ?? false)
                            Status Pendaftaran
                        @else
                            Pilih Periode
                        @endif
                    </span>
                </div>
                <div class="flex items-center gap-6">
                    <!-- <button class="relative p-2 text-slate-400 hover:text-[#018B3E] transition-all">
                                    <span class="material-symbols-outlined">notifications</span>
                                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                                </button> -->
                    <div class="flex items-center gap-3 pl-6" style="border-left: 1px solid #f1f5f9;">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-900 leading-none">{{ auth()->user()->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500 mt-1">ID: {{ auth()->user()->id ?? '—' }}</p>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-[#018B3E]/10 border-2 border-[#018B3E]/20 flex items-center justify-center overflow-hidden">
                            @if(auth()->user()->foto)
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-xl text-[#018B3E]">person</span>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <div class="p-4 sm:p-6 lg:p-8 space-y-6 lg:space-y-8 max-w-7xl w-full">

                {{-- AUTO-HIDE ALERT --}}
                @if(session('success'))
                    <div id="success-alert"
                        class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold animate-slideDown"
                        style="background-color: #018B3E; color: white; box-shadow: 0 4px 20px rgba(1,139,62,0.25);">
                        <span class="material-symbols-outlined text-base">check_circle</span>
                        <span class="flex-1">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="opacity-80 hover:opacity-100">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div id="error-alert" class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold animate-slideDown"
                        style="background-color: #dc2626; color: white; box-shadow: 0 4px 20px rgba(220,38,38,0.25);">
                        <span class="material-symbols-outlined text-base">error</span>
                        <span class="flex-1">{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="opacity-80 hover:opacity-100">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>
                @endif

                @if($pendaftaran ?? false)
                    {{-- ============================================================
                    TAMPILAN SUDAH PUNYA PENDAFTARAN
                    ============================================================ --}}

                    {{-- INFO PERIODE (jika ada) --}}
                    @if(isset($periodeInfo))
                        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3">
                            <span class="material-symbols-outlined text-blue-600 text-sm shrink-0 mt-0.5">event</span>
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <div>
                                        <span class="text-xs text-blue-600 font-semibold uppercase tracking-wider">Periode
                                            Pendaftaran</span>
                                        <p class="text-sm font-bold text-blue-800">{{ $periodeInfo['tahun_ajaran'] }}</p>
                                    </div>
                                    @if($periodeInfo['sisa_hari'] > 0)
                                        <span
                                            class="text-xs font-semibold bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full inline-flex items-center gap-1 w-fit">
                                            <span class="material-symbols-outlined text-sm">hourglass_top</span>
                                            Sisa {{ floor($periodeInfo['sisa_hari']) }} hari
                                        </span>
                                    @endif
                                </div>
                                <div class="flex gap-4 mt-2 text-xs">
                                    <span class="text-slate-600">
                                        <span class="text-slate-400">Buka:</span>
                                        <span class="font-semibold">{{ $periodeInfo['tanggal_buka']->format('d/m/Y') }}</span>
                                    </span>
                                    <span class="text-slate-600">
                                        <span class="text-slate-400">Tutup:</span>
                                        <span class="font-semibold">{{ $periodeInfo['tanggal_tutup']->format('d/m/Y') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Stepper --}}
                    @include('siswa.partials.stepper', ['currentStep' => $currentStep ?? 1])

                    {{-- Status Card --}}
                    <div class="bg-white rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 shadow-sm border border-slate-200">
                        <div class="flex items-center justify-between mb-4 lg:mb-6">
                            <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Status Pendaftaran Anda</h2>
                            @if($pendaftaran ?? false)
                                <span
                                    class="px-3 lg:px-4 py-1.5 lg:py-2 rounded-full text-xs lg:text-sm font-bold flex items-center gap-2"
                                    style="background-color: {{ $pendaftaran->status === 'draft' ? 'rgba(1,139,62,0.1)' : ($pendaftaran->status === 'menunggu_verifikasi' ? 'rgba(246,203,4,0.1)' : 'rgba(1,139,62,0.1)') }}; color: {{ $pendaftaran->status === 'draft' ? '#64748b' : ($pendaftaran->status === 'menunggu_verifikasi' ? '#b45309' : '#018B3E') }};">
                                    <span class="w-1.5 lg:w-2 h-1.5 lg:h-2 rounded-full"
                                        style="background-color: {{ $pendaftaran->status === 'draft' ? '#64748b' : ($pendaftaran->status === 'menunggu_verifikasi' ? '#F6CB04' : '#018B3E') }};"></span>
                                    {{ $pendaftaran->label_status }}
                                </span>
                            @endif
                        </div>

                        @if($pendaftaran ?? false)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                                <div class="space-y-3 lg:space-y-4">
                                    <div>
                                        <p class="text-[10px] lg:text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                            Nomor Pendaftaran</p>
                                        <p class="text-base lg:text-lg font-bold text-[#018B3E]">
                                            {{ $pendaftaran->nomor_pendaftaran }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] lg:text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                            Tanggal Daftar</p>
                                        <p class="text-sm lg:text-base font-semibold text-slate-700">
                                            {{ $pendaftaran->tanggal_daftar->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-3 lg:space-y-4">
                                    <div>
                                        <p class="text-[10px] lg:text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                            Jurusan Pilihan</p>
                                        <p class="text-sm lg:text-base font-semibold text-slate-700">
                                            {{ $pendaftaran->jurusan->nama_jurusan ?? 'Belum dipilih' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] lg:text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                            Langkah Terakhir</p>
                                        <p class="text-sm lg:text-base font-semibold text-slate-700">Langkah
                                            {{ $pendaftaran->step_terakhir }} dari 5
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 lg:mt-6 pt-4 lg:pt-6 border-t border-slate-100">
                                <a href="{{ route('siswa.pendaftaran.step' . $pendaftaran->step_terakhir) }}"
                                    class="inline-flex items-center gap-2 px-4 lg:px-6 py-2.5 lg:py-3 text-white font-bold text-sm lg:text-base rounded-xl transition-all"
                                    style="background-color: #018B3E; box-shadow: 0 8px 20px rgba(1,139,62,0.25);"
                                    onmouseover="this.style.backgroundColor='#016b30';"
                                    onmouseout="this.style.backgroundColor='#018B3E';">
                                    <span class="material-symbols-outlined text-base lg:text-lg">edit</span>
                                    Lanjutkan Pendaftaran (Langkah {{ $pendaftaran->step_terakhir }})
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Progress Info dengan Bukti Pembayaran --}}
                    @if($pendaftaran ?? false)
                        @php
                            $totalDokumen = 6; // 5 wajib + 1 opsional (KIP)
                            $dokumenWajib = ['ijazah', 'kartu_keluarga', 'akte_kelahiran', 'pas_foto', 'bukti_pembayaran'];
                            $dokumenTerupload = $pendaftaran->dokumen->count();
                            $dokumenWajibTerupload = $pendaftaran->dokumen->whereIn('jenis_dokumen', $dokumenWajib)->count();
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
                            <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 shadow-sm border border-slate-200">
                                <div class="flex items-center gap-2 lg:gap-3 mb-2 lg:mb-3">
                                    <div class="w-8 lg:w-10 h-8 lg:h-10 rounded-lg flex items-center justify-center"
                                        style="background-color: rgba(1,139,62,0.1);">
                                        <span class="material-symbols-outlined text-lg lg:text-xl"
                                            style="color: #018B3E;">description</span>
                                    </div>
                                    <div>
                                        <p class="text-xl lg:text-2xl font-bold text-slate-900">{{ $dokumenWajibTerupload }}/5</p>
                                        <p class="text-[10px] lg:text-xs text-slate-500">Dokumen Wajib</p>
                                    </div>
                                </div>
                                <div class="w-full h-1.5 lg:h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full"
                                        style="background-color: #018B3E; width: {{ ($dokumenWajibTerupload / 5) * 100 }}%"></div>
                                </div>
                                <div class="mt-2 text-[10px] text-slate-500">
                                    @if($pendaftaran->dokumen->where('jenis_dokumen', 'bukti_pembayaran')->first())
                                        <span class="text-green-600 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-xs">check_circle</span> Bukti pembayaran sudah
                                            diupload
                                        </span>
                                    @elseif($pendaftaran->step_terakhir >= 5)
                                        <span class="text-red-500 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-xs">error</span> Bukti pembayaran belum diupload
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 shadow-sm border border-slate-200">
                                <div class="flex items-center gap-2 lg:gap-3 mb-2 lg:mb-3">
                                    <div class="w-8 lg:w-10 h-8 lg:h-10 rounded-lg flex items-center justify-center"
                                        style="background-color: rgba(1,139,62,0.1);">
                                        <span class="material-symbols-outlined text-lg lg:text-xl"
                                            style="color: #018B3E;">checklist</span>
                                    </div>
                                    <div>
                                        <p class="text-xl lg:text-2xl font-bold text-slate-900">{{ $pendaftaran->step_terakhir }}/5
                                        </p>
                                        <p class="text-[10px] lg:text-xs text-slate-500">Langkah Selesai</p>
                                    </div>
                                </div>
                                <div class="w-full h-1.5 lg:h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full"
                                        style="background-color: #018B3E; width: {{ ($pendaftaran->step_terakhir / 5) * 100 }}%">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 shadow-sm border border-slate-200">
                                <div class="flex items-center gap-2 lg:gap-3 mb-2 lg:mb-3">
                                    <div class="w-8 lg:w-10 h-8 lg:h-10 rounded-lg flex items-center justify-center"
                                        style="background-color: rgba(1,139,62,0.1);">
                                        <span class="material-symbols-outlined text-lg lg:text-xl"
                                            style="color: #018B3E;">schedule</span>
                                    </div>
                                    <div>
                                        <p class="text-sm lg:text-base font-bold text-slate-900">
                                            {{ $pendaftaran->created_at->diffForHumans() }}
                                        </p>
                                        <p class="text-[10px] lg:text-xs text-slate-500">Terdaftar</p>
                                    </div>
                                </div>

                                {{-- Info Periode di Card --}}
                                @if(isset($periodeInfo))
                                    <div class="mt-2 pt-2 border-t border-slate-100">
                                        <div class="flex items-center gap-1 text-[10px] lg:text-xs text-slate-500">
                                            <span class="material-symbols-outlined text-xs">event</span>
                                            <span>Periode: {{ $periodeInfo['tahun_ajaran'] }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                @else
                    {{-- ============================================================
                    TAMPILAN PILIH PERIODE (BELUM PUNYA PENDAFTARAN)
                    ============================================================ --}}

                    {{-- Header --}}
                    <div class="text-center mb-6 sm:mb-8 px-2">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 mb-2">Pilih Periode Pendaftaran
                        </h1>
                        <p class="text-xs sm:text-sm lg:text-base text-slate-500 px-2">Pilih periode pendaftaran yang tersedia
                            untuk memulai proses PPDB</p>
                    </div>

                    {{-- Tab Filter - Responsive Scroll --}}
                    <div class="flex justify-center mb-6 sm:mb-8 px-2 overflow-x-auto pb-2">
                        <div class="inline-flex p-1 bg-white rounded-xl shadow-sm border border-slate-200 min-w-max">
                            <button onclick="filterPeriode('semua')"
                                class="filter-btn active px-3 sm:px-6 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all whitespace-nowrap"
                                style="background-color: #018B3E; color: white;" data-filter="semua">
                                Semua ({{ $periodeTersedia->count() }})
                            </button>
                            <button onclick="filterPeriode('berlangsung')"
                                class="filter-btn px-3 sm:px-6 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all whitespace-nowrap"
                                style="color: #64748b;" data-filter="berlangsung">
                                Sedang Berlangsung
                            </button>
                            <button onclick="filterPeriode('akan_datang')"
                                class="filter-btn px-3 sm:px-6 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all whitespace-nowrap"
                                style="color: #64748b;" data-filter="akan_datang">
                                Akan Datang
                            </button>
                            <button onclick="filterPeriode('berakhir')"
                                class="filter-btn px-3 sm:px-6 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all whitespace-nowrap"
                                style="color: #64748b;" data-filter="berakhir">
                                Telah Berakhir
                            </button>
                        </div>
                    </div>

                    {{-- Daftar Periode dalam Card --}}
                    @if($periodeTersedia->isEmpty())
                        <div
                            class="bg-white rounded-xl sm:rounded-2xl p-6 sm:p-8 lg:p-12 text-center border border-slate-200 mx-2 sm:mx-0">
                            <span
                                class="material-symbols-outlined text-4xl sm:text-5xl lg:text-6xl text-slate-300 mb-3 sm:mb-4">event_busy</span>
                            <h3 class="text-lg sm:text-xl lg:text-xl font-bold text-slate-700 mb-2">Tidak Ada Periode Aktif</h3>
                            <p class="text-xs sm:text-sm text-slate-500 px-2">Saat ini belum ada periode pendaftaran yang tersedia.
                                Silakan cek kembali nanti.</p>
                        </div>
                    @else
                        {{-- Urutkan: berlangsung pertama, lalu akan datang, lalu berakhir --}}
                        @php
                            $sortedPeriode = $periodeTersedia->sortByDesc(function ($item) {
                                if ($item->tanggal_buka <= now() && $item->tanggal_tutup >= now())
                                    return 3;
                                if ($item->tanggal_buka > now())
                                    return 2;
                                return 1;
                            });
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 px-2 sm:px-0">
                            @foreach($sortedPeriode as $periode)
                                @php
                                    $status = $periode->tanggal_tutup < now() ? 'berakhir' :
                                        ($periode->tanggal_buka > now() ? 'akan_datang' : 'berlangsung');

                                    $statusColor = [
                                        'berlangsung' => [
                                            'bg' => 'bg-[#018B3E]/10',
                                            'border' => 'border-[#018B3E]/20',
                                            'text' => 'text-[#018B3E]',
                                            'badge' => 'bg-[#018B3E]',
                                            'lightBg' => 'bg-[#018B3E]/5'
                                        ],
                                        'akan_datang' => [
                                            'bg' => 'bg-blue-50',
                                            'border' => 'border-blue-200',
                                            'text' => 'text-blue-700',
                                            'badge' => 'bg-blue-500',
                                            'lightBg' => 'bg-blue-50/50'
                                        ],
                                        'berakhir' => [
                                            'bg' => 'bg-slate-100',
                                            'border' => 'border-slate-200',
                                            'text' => 'text-slate-500',
                                            'badge' => 'bg-slate-400',
                                            'lightBg' => 'bg-slate-50'
                                        ],
                                    ];

                                    $sc = $statusColor[$status];
                                @endphp

                                <div class="periode-card bg-white rounded-xl sm:rounded-2xl p-4 sm:p-5 lg:p-6 border border-slate-200 hover:shadow-lg transition-all 
                                                                                                                                                                                                                                                                                        {{ $status == 'berlangsung' ? 'ring-2 ring-[#018B3E]/20' : ($status == 'berakhir' ? 'opacity-70' : '') }}"
                                    data-status="{{ $status }}" style="{{ $status == 'berlangsung' ? 'border-color: #018B3E;' : '' }}">

                                    {{-- Header dengan Badge Status --}}
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <div
                                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl {{ $sc['bg'] }} flex items-center justify-center {{ $sc['text'] }} shrink-0">
                                                <span class="material-symbols-outlined text-xl sm:text-2xl">event</span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h3 class="font-bold text-base sm:text-lg text-slate-900 truncate">
                                                    {{ $periode->tahun_ajaran }}
                                                </h3>
                                                <p class="text-[10px] sm:text-xs text-slate-500">Periode Pendaftaran</p>
                                            </div>
                                        </div>
                                        <span
                                            class="px-2 sm:px-3 py-1 text-[10px] sm:text-xs font-semibold rounded-full {{ $sc['bg'] }} {{ $sc['text'] }} border {{ $sc['border'] }} w-fit sm:w-auto">
                                            {{ $status == 'berlangsung' ? 'Sedang Berlangsung' : ($status == 'akan_datang' ? 'Akan Datang' : 'Telah Berakhir') }}
                                        </span>
                                    </div>

                                    {{-- Progress Bar untuk Periode Berlangsung --}}
                                    @if($status == 'berlangsung')
                                        @php
                                            $totalHari = $periode->tanggal_buka->diffInDays($periode->tanggal_tutup);
                                            $hariTerlewat = $periode->tanggal_buka->diffInDays(now());
                                            $persentase = min(100, ($hariTerlewat / max($totalHari, 1)) * 100);
                                        @endphp
                                        <div class="mb-4">
                                            <div class="flex items-center justify-between text-[10px] sm:text-xs mb-1">
                                                <span class="text-slate-500">Progress</span>
                                                <span class="font-semibold" style="color: #018B3E;">{{ round($persentase) }}%</span>
                                            </div>
                                            <div class="w-full h-1.5 sm:h-2 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full"
                                                    style="background-color: #018B3E; width: {{ $persentase }}%"></div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Info Tanggal --}}
                                    <div class="grid grid-cols-2 gap-2 sm:gap-3 mb-4">
                                        <div class="p-2 sm:p-3 {{ $sc['lightBg'] }} rounded-xl">
                                            <span class="material-symbols-outlined text-xs sm:text-sm"
                                                style="color: #018B3E;">event_available</span>
                                            <p class="text-[10px] sm:text-xs text-slate-500 mt-1">Buka</p>
                                            <p class="text-xs sm:text-sm font-semibold truncate">
                                                {{ $periode->tanggal_buka->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div class="p-2 sm:p-3 {{ $sc['lightBg'] }} rounded-xl">
                                            <span class="material-symbols-outlined text-xs sm:text-sm"
                                                style="color: #018B3E;">event_busy</span>
                                            <p class="text-[10px] sm:text-xs text-slate-500 mt-1">Tutup</p>
                                            <p class="text-xs sm:text-sm font-semibold truncate">
                                                {{ $periode->tanggal_tutup->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Info Tambahan --}}
                                    <div class="space-y-1.5 sm:space-y-2 mb-4 text-xs sm:text-sm">
                                        @if($periode->tanggal_pengumuman)
                                            <div class="flex items-center gap-1.5 sm:gap-2">
                                                <span class="material-symbols-outlined text-[10px] sm:text-xs shrink-0"
                                                    style="color: #018B3E;">campaign</span>
                                                <span class="text-slate-600 text-[10px] sm:text-xs truncate">
                                                    <span class="hidden xs:inline">Pengumuman:</span>
                                                    <span class="font-semibold">{{ $periode->tanggal_pengumuman->format('d/m/Y') }}</span>
                                                </span>
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-1.5 sm:gap-2">
                                            <span class="material-symbols-outlined text-[10px] sm:text-xs shrink-0"
                                                style="color: #018B3E;">payments</span>
                                            <span class="text-slate-600 text-[10px] sm:text-xs truncate">
                                                <span class="hidden xs:inline">Biaya:</span>
                                                <span
                                                    class="font-semibold {{ $periode->biaya_pendaftaran == 0 ? 'text-green-600' : '' }}"
                                                    style="{{ $periode->biaya_pendaftaran == 0 ? 'color: #018B3E;' : '' }}">
                                                    {{ $periode->biaya_pendaftaran > 0 ? 'Rp ' . number_format($periode->biaya_pendaftaran, 0, ',', '.') : 'Gratis' }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Tombol Aksi --}}
                                    @if($status == 'berlangsung')
                                        @php $sisaHari = now()->diffInDays($periode->tanggal_tutup, false); @endphp
                                        <div class="mb-4 p-2 sm:p-3 {{ $sc['lightBg'] }} rounded-xl">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[10px] sm:text-xs font-semibold" style="color: #018B3E;">Sisa
                                                    waktu:</span>
                                                <span class="text-xs sm:text-sm font-bold" style="color: #018B3E;">{{ floor($sisaHari) }}
                                                    hari</span>
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('siswa.pendaftaran.pilih-periode') }}">
                                            @csrf
                                            <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                                            <button type="submit"
                                                class="w-full py-2.5 sm:py-3 text-white font-bold rounded-xl hover:opacity-90 transition-all flex items-center justify-center gap-2 text-xs sm:text-sm"
                                                style="background-color: #018B3E;">
                                                <span class="material-symbols-outlined text-base sm:text-lg">how_to_reg</span>
                                                <span class="truncate">Pilih Periode Ini</span>
                                            </button>
                                        </form>
                                    @else
                                        <button disabled
                                            class="w-full py-2.5 sm:py-3 bg-slate-200 text-slate-500 font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2 text-xs sm:text-sm">
                                            <span class="material-symbols-outlined text-base sm:text-lg">block</span>
                                            <span
                                                class="truncate">{{ $status == 'akan_datang' ? 'Belum Dibuka' : 'Periode Berakhir' }}</span>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Informasi Tambahan --}}
                    <div class="mt-8 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-blue-600 text-sm shrink-0 mt-0.5">info</span>
                            <div class="text-xs text-blue-800">
                                <p class="font-semibold mb-1">Informasi Penting:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Pilih periode pendaftaran yang sesuai dengan gelombang yang Anda inginkan</li>
                                    <li>Setelah memilih periode, Anda akan diarahkan ke formulir pendaftaran</li>
                                    <li>Data pendaftaran akan terkait dengan periode yang dipilih</li>
                                    <li>Pastikan memilih periode sebelum tanggal tutup</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Help Links --}}
                <div class="flex flex-col items-center gap-3 lg:gap-4 text-center pt-4 lg:pt-8">
                    <p class="text-xs lg:text-sm text-slate-500">Butuh bantuan pengisian? Hubungi Panitia PPDB</p>
                    <div class="flex flex-col sm:flex-row gap-2 lg:gap-4">
                        <a href="#"
                            class="flex items-center justify-center gap-2 font-bold text-xs lg:text-sm px-4 py-2 rounded-full border transition-all whitespace-nowrap"
                            style="color: #018B3E; background-color: rgba(1,139,62,0.05); border-color: rgba(1,139,62,0.1);"
                            onmouseover="this.style.backgroundColor='rgba(1,139,62,0.1)';"
                            onmouseout="this.style.backgroundColor='rgba(1,139,62,0.05)';">
                            <span class="material-symbols-outlined text-sm lg:text-base">support_agent</span>
                            WhatsApp Center
                        </a>
                        <!-- <a href="#"
                                                                                    class="flex items-center justify-center gap-2 font-bold text-xs lg:text-sm px-4 py-2 rounded-full border transition-all whitespace-nowrap"
                                                                                    style="color: #018B3E; background-color: rgba(1,139,62,0.05); border-color: rgba(1,139,62,0.1);"
                                                                                    onmouseover="this.style.backgroundColor='rgba(1,139,62,0.1)';"
                                                                                    onmouseout="this.style.backgroundColor='rgba(1,139,62,0.05)';">
                                                                                    <span class="material-symbols-outlined text-sm lg:text-base">description</span>
                                                                                    Panduan Pendaftaran
                                                                                </a> -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
            } else {
                sidebar.classList.add('hidden');
            }
        }

        // Mobile menu button
        document.getElementById('mobile-menu-button')?.addEventListener('click', toggleMobileSidebar);

        // Close sidebar when clicking outside
        document.addEventListener('click', function (e) {
            const sidebar = document.getElementById('mobile-sidebar');
            const menuButton = document.getElementById('mobile-menu-button');
            if (sidebar && !sidebar.classList.contains('hidden')) {
                if (!sidebar.contains(e.target) && !menuButton?.contains(e.target)) {
                    sidebar.classList.add('hidden');
                }
            }
        });

        // Filter periode
        function filterPeriode(status) {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.style.backgroundColor = '';
                btn.style.color = '#64748b';
            });

            let activeBtn = document.querySelector(`.filter-btn[data-filter="${status}"]`);
            if (activeBtn) {
                activeBtn.style.backgroundColor = '#018B3E';
                activeBtn.style.color = 'white';
            }

            document.querySelectorAll('.periode-card').forEach(card => {
                if (status === 'semua' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Auto-hide alert setelah 3 detik
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-hide success alert
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease';
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 500);
                }, 3000);
            }

            // Auto-hide error alert
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.transition = 'opacity 0.5s ease';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => {
                        errorAlert.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>

    <style>
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }

        .filter-btn {
            transition: all 0.2s ease;
        }

        .filter-btn:hover {
            background-color: rgba(1, 139, 62, 0.1);
            color: #018B3E;
        }

        /* Untuk layar sangat kecil (di bawah 400px) */
        @media (max-width: 400px) {
            .periode-card {
                padding: 1rem;
            }

            .material-symbols-outlined.text-lg {
                font-size: 1.25rem;
            }
        }

        /* Fix untuk truncate text */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>

@endsection