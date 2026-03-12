@extends('layouts.app')

@section('title', 'PPDB SMK NU II Medan - Penerimaan Peserta Didik Baru')

@section('content')

<div class="relative flex min-h-screen flex-col overflow-x-hidden">
        @include('partials.navbar')

        {{-- Hero Section --}}
        <section class="relative py-16 lg:py-24 overflow-hidden" id="beranda"
            style="background-color: var(--color-background-light, #F6F4F7);">
            {{-- Decorative blobs --}}
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl opacity-20 pointer-events-none"
                style="background-color: #018B3E;"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full blur-3xl opacity-15 pointer-events-none"
                style="background-color: #F6CB04;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="flex flex-col gap-6 text-left z-10" data-aos="fade-right" data-aos-duration="1000">
                        {{-- Badge --}}
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full w-fit font-bold text-xs uppercase tracking-wider"
                            style="background-color: rgba(1,139,62,0.12); color: #018B3E;">
                            <span class="material-symbols-outlined text-sm">campaign</span>
                            <span>PPDB Telah Dibuka</span>
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight"
                            style="color: #0f2318;">
                            Penerimaan Peserta Didik Baru
                            <span style="color: #018B3E;">(PPDB)</span>
                            Tahun Pelajaran 2026/2027
                        </h1>

                        <p class="text-lg max-w-xl" style="color: #3a5a46;">
                            Wujudkan masa depan gemilang dengan pendidikan vokasi berkualitas, fasilitas modern, dan
                            penguatan karakter Islami di SMK Swasta Nahdatul Ulama II Medan.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 mt-4">
                            <a href="{{ route('register') }}"
                                class="px-8 py-4 rounded-xl font-black text-lg shadow-lg flex items-center justify-center gap-2 hover:brightness-105 transition-all"
                                style="background-color: #F6CB04; color: #0f2318;">
                                Daftar Sekarang
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <div class="relative" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                        <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full blur-3xl opacity-10"
                            style="background-color: #018B3E;"></div>
                        <div class="absolute -bottom-10 -left-10 w-64 h-64 rounded-full blur-3xl opacity-20"
                            style="background-color: #F6CB04;"></div>
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border-8 aspect-[4/3]"
                            style="border-color: white; background-image: url('{{ asset('images/hero-section.png') }}'); background-size: cover; background-position: center;">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── STATS BAR ────────────────────────────────────────────── --}}
        <div class="py-8" style="background-color:#018B3E;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
                    <div data-aos="zoom-in" data-aos-delay="0">
                        <div class="text-3xl font-black" style="color:#F6CB04;">150+</div>
                        <div class="text-sm opacity-80 mt-1">Siswa Aktif</div>
                    </div>
                    <div data-aos="zoom-in" data-aos-delay="100">
                        <div class="text-3xl font-black" style="color:#F6CB04;">7</div>
                        <div class="text-sm opacity-80 mt-1">Jurusan Unggulan</div>
                    </div>
                    <div data-aos="zoom-in" data-aos-delay="200">
                        <div class="text-3xl font-black" style="color:#F6CB04;">10+</div>
                        <div class="text-sm opacity-80 mt-1">Mitra Industri</div>
                    </div>
                    <div data-aos="zoom-in" data-aos-delay="300">
                        <div class="text-3xl font-black" style="color:#F6CB04;">B</div>
                        <div class="text-sm opacity-80 mt-1">Akreditasi BNSP</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── PERIODE PPDB ─────────────────────────────────────────── --}}
<section id="periode" class="py-20 relative overflow-hidden" style="background-color: #F6F4F7;">

    {{-- Decorative bg elements dengan warna terang --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full opacity-10" style="background-color: #018B3E;"></div>
        <div class="absolute -bottom-32 -left-32 w-[400px] h-[400px] rounded-full opacity-10" style="background-color: #F6CB04;"></div>
        {{-- Grid pattern halus --}}
        <svg class="absolute inset-0 w-full h-full opacity-[0.02]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-light" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#018B3E" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-light)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14" data-aos="fade-up">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full mb-4 text-xs font-bold uppercase tracking-widest"
                    style="background-color: rgba(1,139,62,0.08); color: #018B3E; border: 1px solid rgba(1,139,62,0.15);">
                    <span class="size-1.5 rounded-full bg-[#018B3E] animate-pulse inline-block"></span>
                    Pendaftaran Aktif
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 leading-tight">
                    Jadwal Periode<br>
                    <span style="color: #018B3E;">Penerimaan Siswa Baru</span>
                </h2>
            </div>
            <p class="text-sm max-w-xs md:text-right text-slate-500">
                Pastikan kamu mendaftar sebelum batas waktu. Kuota terbatas untuk setiap jurusan.
            </p>
        </div>

        @php
            $periodeList = \App\Models\PengaturanPpdb::where('is_active', true)
                ->orderBy('tanggal_buka', 'asc')
                ->get();
        @endphp

        @if($periodeList->isEmpty())
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center py-20 gap-5" data-aos="fade-up">
                <div class="size-20 rounded-2xl flex items-center justify-center bg-white shadow-sm border border-slate-200">
                    <span class="material-symbols-outlined text-4xl text-slate-300">event_busy</span>
                </div>
                <div class="text-center">
                    <p class="text-lg font-bold text-slate-700 mb-1">Belum ada periode PPDB aktif</p>
                    <p class="text-sm text-slate-400">Pantau terus halaman ini untuk informasi pembukaan PPDB berikutnya.</p>
                </div>
            </div>
        @else

            {{-- Layout: stacked rows --}}
            <div class="space-y-px" data-aos="fade-up" data-aos-delay="100">

                {{-- Table Header --}}
                <div class="hidden md:grid grid-cols-[1fr_160px_160px_120px_180px] gap-6 px-6 py-3 mb-2 bg-white/50 rounded-t-2xl">
                    @foreach(['Periode / Tahun Ajaran','Tanggal Buka','Tanggal Tutup','Biaya',''] as $h)
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $h }}</div>
                    @endforeach
                </div>

                @foreach($periodeList as $i => $p)
                @php
                    $now         = now();
                    $buka        = \Carbon\Carbon::parse($p->tanggal_buka);
                    $tutup       = \Carbon\Carbon::parse($p->tanggal_tutup);
                    $isBelumBuka = $now->lt($buka);
                    $isBuka      = $now->between($buka, $tutup);
                    $isDitutup   = $now->gt($tutup);
                    $sisa        = $isBuka ? max(0, (int) $now->diffInDays($tutup, false)) : null;
                    
                    // Warna berdasarkan status
                    $statusColor = $isBuka ? '#018B3E' : ($isBelumBuka ? '#F6CB04' : '#94a3b8');
                    $bgColor = $isBuka ? 'rgba(1,139,62,0.02)' : 'white';
                    $borderColor = $isBuka ? 'rgba(1,139,62,0.2)' : 'rgba(0,0,0,0.05)';
                @endphp

                <div class="group relative rounded-2xl transition-all duration-300 overflow-hidden bg-white border hover:shadow-lg"
                    style="border-color: {{ $borderColor }}; background-color: {{ $bgColor }};"
                    data-aos="fade-up" data-aos-delay="{{ 150 + $i * 80 }}">

                    {{-- Left accent line --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl transition-all duration-300"
                        style="background-color: {{ $statusColor }};"></div>

                    {{-- Active glow untuk periode berlangsung --}}
                    @if($isBuka)
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none rounded-2xl"
                        style="box-shadow: inset 0 0 0 1px rgba(1,139,62,0.3), 0 4px 20px -8px rgba(1,139,62,0.3);"></div>
                    @endif

                    {{-- Row content --}}
                    <div class="pl-5 pr-4 py-5 md:py-4 grid grid-cols-1 md:grid-cols-[1fr_160px_160px_120px_180px] gap-4 md:gap-6 items-center">

                        {{-- Nama periode --}}
                        <div class="flex items-center gap-4">
                            <div class="size-10 shrink-0 rounded-xl flex items-center justify-center"
                                style="background-color: {{ $isBuka ? 'rgba(1,139,62,0.1)' : 'rgba(0,0,0,0.02)' }};">
                                <span class="material-symbols-outlined text-lg"
                                    style="color: {{ $statusColor }};">event_note</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <p class="font-black text-slate-900 text-base">PPDB {{ $p->tahun_ajaran }}</p>
                                    @if($isBuka)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                                            style="background-color: rgba(1,139,62,0.1); color: #018B3E; border: 1px solid rgba(1,139,62,0.2);">
                                            <span class="size-1 rounded-full bg-[#018B3E] animate-ping inline-block"></span>
                                            Sedang Berlangsung
                                        </span>
                                    @elseif($isBelumBuka)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                                            style="background-color: rgba(246,203,4,0.1); color: #b45309; border: 1px solid rgba(246,203,4,0.2);">
                                            Akan Datang
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                                            style="background-color: rgba(0,0,0,0.03); color: #94a3b8; border: 1px solid rgba(0,0,0,0.05);">
                                            Ditutup
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs mt-0.5 text-slate-400">SMK NU II Medan</p>
                            </div>
                        </div>

                        {{-- Tanggal Buka --}}
                        <div class="md:block">
                            <p class="text-[10px] font-semibold uppercase tracking-wider mb-0.5 md:hidden text-slate-400">Dibuka</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $buka->translatedFormat('d M Y') }}</p>
                            <p class="text-[10px] text-slate-400">{{ $buka->translatedFormat('l') }}</p>
                        </div>

                        {{-- Tanggal Tutup --}}
                        <div class="md:block">
                            <p class="text-[10px] font-semibold uppercase tracking-wider mb-0.5 md:hidden text-slate-400">Ditutup</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $tutup->translatedFormat('d M Y') }}</p>
                            <p class="text-[10px] text-slate-400">{{ $tutup->translatedFormat('l') }}</p>
                        </div>

                        {{-- Biaya --}}
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wider mb-0.5 md:hidden text-slate-400">Biaya</p>
                            @if($p->biaya_pendaftaran > 0)
                                <p class="text-sm font-bold text-[#018B3E]">Rp {{ number_format($p->biaya_pendaftaran, 0, ',', '.') }}</p>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-black"
                                    style="background-color: rgba(1,139,62,0.08); color: #018B3E;">
                                    <span class="material-symbols-outlined text-sm">check</span>
                                    Gratis
                                </span>
                            @endif
                        </div>

                        {{-- CTA --}}
                        <div>
                            @if($isBuka)
                                @auth
                                    @if(auth()->user()->role === 'siswa')
                                        <a href="{{ route('siswa.pendaftaran.index') }}"
                                            class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl font-bold text-sm transition-all hover:brightness-110 shadow-lg"
                                            style="background-color: #018B3E; color: white;">
                                            <span class="material-symbols-outlined text-base">how_to_reg</span>
                                            Daftar Sekarang
                                        </a>
                                    @else
                                        <span class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl font-bold text-sm cursor-not-allowed bg-slate-100 text-slate-400">
                                            <span class="material-symbols-outlined text-base">block</span>
                                            Khusus Siswa
                                        </span>
                                    @endif
                                @else
                                    <a href="{{ route('register') }}"
                                        class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl font-black text-sm transition-all hover:brightness-110 shadow-lg"
                                        style="background-color: #F6CB04; color: #0f2318;">
                                        <span class="material-symbols-outlined text-base">login</span>
                                        Daftar / Masuk
                                    </a>
                                @endauth

                                {{-- Sisa hari chip --}}
                                @if($sisa !== null)
                                <p class="text-center text-[10px] mt-1.5 font-semibold"
                                    style="color: {{ $sisa <= 7 ? '#dc2626' : '#94a3b8' }};">
                                    {{ $sisa > 0 ? 'Sisa ' . $sisa . ' hari' : 'Hari terakhir!' }}
                                </p>
                                @endif
                            @elseif($isBelumBuka)
                                <div class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl text-sm font-semibold cursor-not-allowed bg-slate-100 text-slate-400 border border-slate-200">
                                    <span class="material-symbols-outlined text-base">schedule</span>
                                    Belum Dibuka
                                </div>
                                <p class="text-center text-[10px] mt-1.5 text-slate-400">
                                    Buka {{ $buka->diffForHumans() }}
                                </p>
                            @else
                                <div class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl text-sm font-semibold cursor-not-allowed bg-slate-100 text-slate-400 border border-slate-200">
                                    <span class="material-symbols-outlined text-base">lock</span>
                                    Ditutup
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach

            </div>

            {{-- Bottom note dengan tombol lihat pengumuman --}}
<div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4 p-4 rounded-xl bg-white/50 border border-slate-200" data-aos="fade-up" data-aos-delay="300">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-sm" style="color: #018B3E;">info</span>
        <p class="text-xs text-slate-600">
            *Pengumuman hasil seleksi akan diinformasikan melalui website dan papan pengumuman sekolah.
        </p>
    </div>
    <a href="{{ route('pengumuman.publik') }}" 
       class="inline-flex items-center gap-1 px-4 py-2 rounded-xl text-xs font-bold transition-all hover:brightness-110 whitespace-nowrap"
       style="background-color: #018B3E; color: white;">
        <span class="material-symbols-outlined text-sm">campaign</span>
        Lihat Pengumuman
        <span class="material-symbols-outlined text-sm">arrow_forward</span>
    </a>
</div>

        @endif
    </div>
</section>

        {{-- ── TENTANG ──────────────────────────────────────────────── --}}
        <section class="py-20" id="tentang" style="background-color:white;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="font-bold text-sm tracking-widest uppercase mb-2 block" style="color:#018B3E;">Kenapa Memilih Kami?</span>
                    <h3 class="text-3xl sm:text-4xl font-black" style="color:#0f2318;">Tentang SMK NU II Medan</h3>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach([
                        ['icon'=>'workspace_premium','title'=>'Akreditasi Unggul', 'desc'=>'Kurikulum kami telah disesuaikan dengan kebutuhan industri modern dan terakreditasi oleh BNSP.'],
                        ['icon'=>'biotech',          'title'=>'Fasilitas Modern',  'desc'=>'Laboratorium praktik lengkap mulai dari Teknik Komputer, Akuntansi, hingga Workshop Otomotif.'],
                        ['icon'=>'handshake',        'title'=>'Jejaring Industri', 'desc'=>'Bekerjasama dengan lebih dari 50+ perusahaan nasional untuk program magang dan penempatan kerja.'],
                    ] as $idx => $card)
                    <div class="p-8 rounded-2xl border shadow-sm hover:shadow-md transition-shadow"
                        style="background-color:#F6F4F7; border-color:rgba(1,139,62,0.12);"
                        data-aos="fade-up" data-aos-delay="{{ $idx * 120 }}">
                        <div class="size-14 text-white rounded-xl flex items-center justify-center mb-6" style="background-color:#018B3E;">
                            <span class="material-symbols-outlined text-3xl">{{ $card['icon'] }}</span>
                        </div>
                        <h4 class="text-xl font-bold mb-3" style="color:#0f2318;">{{ $card['title'] }}</h4>
                        <p style="color:#3a5a46;">{{ $card['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

       {{-- Alur PPDB --}}
        <section class="py-20" id="alur" style="background-color: #F6F4F7;" data-aos="fade-up">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-down">
                    <span class="font-bold text-sm tracking-widest uppercase mb-2 block"
                        style="color: #018B3E;">Prosedur Pendaftaran</span>
                    <h3 class="text-3xl sm:text-4xl font-black" style="color: #0f2318;">Alur Pendaftaran</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative">
                    {{-- Garis penghubung --}}
                    <div class="hidden md:block absolute top-12 left-[12.5%] right-[12.5%] h-0.5 bg-gradient-to-r from-primary/20 via-primary/40 to-primary/20"
                        style="background: linear-gradient(90deg, rgba(1,139,62,0.1) 0%, #018B3E 50%, rgba(1,139,62,0.1) 100%);">
                    </div>

                    @php
                        $steps = [
                            ['icon' => 'how_to_reg', 'step' => '1. Registrasi Online', 'desc' => 'Isi formulir pendaftaran melalui website resmi sekolah.', 'date' => 'Jan - Mar 2026'],
                            ['icon' => 'folder_zip', 'step' => '2. Verifikasi Berkas', 'desc' => 'Upload dokumen persyaratan untuk divalidasi petugas.', 'date' => 'Apr 2026'],
                            ['icon' => 'payments', 'step' => '3. Pembayaran', 'desc' => 'Lakukan pembayaran biaya pendaftaran (jika ada).', 'date' => 'Apr - Mei 2026'],
                            ['icon' => 'how_to_reg', 'step' => '4. Daftar Ulang', 'desc' => 'Penyelesaian administrasi bagi siswa yang dinyatakan lulus.', 'date' => 'Jun 2026'],
                        ];
                    @endphp

                    @foreach($steps as $index => $item)
                        <div class="flex flex-col items-center text-center group z-10"
                             data-aos="fade-up"
                             data-aos-delay="{{ $index * 150 }}">
                            {{-- Lingkaran dengan ikon --}}
                            <div class="size-20 rounded-full border-4 flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300 relative bg-white"
                                style="border-color: #018B3E;">
                                <span class="material-symbols-outlined text-3xl" style="color: #018B3E;">{{ $item['icon'] }}</span>
                                
                                {{-- Nomor urut kecil di pojok --}}
                                <div class="absolute -top-1 -right-1 size-6 rounded-full flex items-center justify-center text-xs font-bold text-white"
                                    style="background-color: #F6CB04;">
                                    {{ $index + 1 }}
                                </div>
                            </div>
                            
                            {{-- Judul step --}}
                            <h5 class="font-bold text-lg mb-2" style="color: #0f2318;">{{ $item['step'] }}</h5>
                            
                            {{-- Deskripsi --}}
                            <p class="text-sm mb-2 px-2" style="color: #3a5a46;">{{ $item['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ── SYARAT & DOKUMEN ────────────────────────────────────── --}}
        <section class="py-20" id="syarat" style="background-color:white;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div data-aos="fade-right">
                        <span class="font-bold text-sm tracking-widest uppercase mb-2 block" style="color:#018B3E;">Persiapan</span>
                        <h3 class="text-3xl sm:text-4xl font-black mb-6" style="color:#0f2318;">Syarat & Dokumen Pendaftaran</h3>
                        <p class="mb-8" style="color:#3a5a46;">Pastikan seluruh dokumen dalam format fisik maupun digital (Scan PDF) telah disiapkan sebelum melakukan pendaftaran online.</p>
                        <div class="space-y-4">
                            @foreach([
                                ['title'=>'Fotokopi Ijazah / SKL',          'sub'=>'Dilegalisir sebanyak 3 lembar.'],
                                ['title'=>'Kartu Keluarga & Akte Kelahiran', 'sub'=>'Fotokopi masing-masing 2 lembar.'],
                                ['title'=>'Pas Foto Terbaru (3x4 & 4x6)',   'sub'=>'Latar belakang merah, 4 lembar.'],
                                ['title'=>'KPS / KIP / PKH (Opsional)',      'sub'=>'Bagi pendaftar jalur bantuan pemerintah.'],
                            ] as $doc)
                            <div class="flex items-start gap-4 p-4 rounded-xl" style="background-color:#F6F4F7;">
                                <span class="material-symbols-outlined" style="color:#018B3E;">check_circle</span>
                                <div>
                                    <p class="font-bold" style="color:#0f2318;">{{ $doc['title'] }}</p>
                                    <p class="text-sm" style="color:#3a5a46;">{{ $doc['sub'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden shadow-2xl"
                        style="background-color:#018B3E;"
                        data-aos="fade-left" data-aos-delay="100">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="material-symbols-outlined text-[160px]">verified_user</span>
                        </div>
                        <h4 class="text-2xl font-bold mb-4">Informasi Tambahan</h4>
                        <ul class="space-y-4 mb-8">
                            @foreach(['Usia maksimal 21 tahun per Juli 2026.','Tidak bertato dan tidak bertindik.','Sehat jasmani dan rohani.'] as $info)
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined" style="color:#F6CB04;">info</span>
                                <span>{{ $info }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="p-6 rounded-2xl border" style="background-color:rgba(255,255,255,0.1); border-color:rgba(255,255,255,0.2);">
                            <p class="text-sm font-medium mb-4">Punya pertanyaan mengenai syarat khusus jurusan?</p>
                            <a href="https://wa.me/6281266857686?text={{ urlencode('Halo admin PPDB SMK NU II Medan, saya ingin bertanya mengenai syarat khusus jurusan. Mohon informasinya. Terima kasih.') }}"
                                target="_blank" rel="noopener noreferrer"
                                class="w-full font-bold py-3 rounded-xl transition-all hover:brightness-110 inline-block text-center"
                                style="background-color:#F6CB04; color:#0f2318;">
                                Hubungi Admin PPDB
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── FAQ ────────────────────────────────────────────────── --}}
        <section class="py-20" id="faq" style="background-color:#F6F4F7;">
            <div class="max-w-3xl mx-auto px-4 sm:px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="font-bold text-sm tracking-widest uppercase mb-2 block" style="color:#018B3E;">Bantuan</span>
                    <h3 class="text-3xl sm:text-4xl font-black" style="color:#0f2318;">Pertanyaan Sering Diajukan</h3>
                </div>
                <div class="space-y-4">
                    @foreach([
                        ['q'=>'Kapan pendaftaran offline dilayani di sekolah?',
                         'a'=>'Pendaftaran offline dilayani setiap hari Senin - Sabtu, pukul 08.00 s/d 15.00 WIB di Sekretariat PPDB SMK NU II Medan.',
                         'open'=>true],
                        ['q'=>'Berapa biaya pendaftaran awal?',
                         'a'=>'Biaya pendaftaran untuk tahun ajaran 2026/2027 adalah Gratis. Siswa hanya perlu membayar biaya administrasi daftar ulang jika sudah dinyatakan lulus.',
                         'open'=>false],
                        ['q'=>'Apakah ada beasiswa prestasi?',
                         'a'=>"Ya, kami menyediakan beasiswa penuh bagi siswa berprestasi di bidang akademik maupun non-akademik tingkat kota/provinsi, serta beasiswa khusus bagi hafidz Qur'an.",
                         'open'=>false],
                        ['q'=>'Apa saja jurusan yang tersedia?',
                         'a'=>'Tersedia 4 Kompetensi Keahlian: Teknik Komputer Jaringan (TKJ), Akuntansi & Keuangan Lembaga (AKL), Bisnis Daring & Pemasaran (BDP), dan Multimedia.',
                         'open'=>false],
                    ] as $idx => $faq)
                    <div class="collapse collapse-plus shadow-sm border rounded-xl overflow-hidden"
                        style="background-color:white; border-color:rgba(1,139,62,0.15);"
                        data-aos="fade-up" data-aos-delay="{{ $idx * 80 }}">
                        <input type="radio" name="faq-accordion" {{ $faq['open'] ? 'checked' : '' }} />
                        <div class="collapse-title text-lg font-bold" style="color:#0f2318;">{{ $faq['q'] }}</div>
                        <div class="collapse-content">
                            <p style="color:#3a5a46;">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
         @include('partials.footer')
    </div>{{-- end drawer-content --}}

    {{-- ── MOBILE DRAWER ───────────────────────────────────────────── --}}
    <div class="drawer-side z-[60]">
        <label for="mobile-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
        <div class="min-h-full w-72 flex flex-col" style="background-color:#0f2318;">

            <div class="flex items-center justify-between px-6 py-5 border-b" style="border-color:rgba(255,255,255,0.08);">
                <div class="flex items-center gap-3">
                    <div class="size-9 rounded-full flex items-center justify-center" style="background-color:#018B3E;">
                        <span class="material-symbols-outlined text-white text-xl">school</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white uppercase leading-tight">SMK NU II Medan</p>
                        <p class="text-[10px] opacity-60 text-white">Generasi Unggul & Islami</p>
                    </div>
                </div>
                <label for="mobile-drawer" class="btn btn-ghost btn-sm p-1" style="color:rgba(255,255,255,0.6);">
                    <span class="material-symbols-outlined">close</span>
                </label>
            </div>

            <nav class="flex flex-col px-4 py-6 gap-1 flex-1">
                @foreach([
                    ['href'=>'#beranda','icon'=>'home',         'label'=>'Beranda'],
                    ['href'=>'#tentang','icon'=>'info',         'label'=>'Tentang'],
                    ['href'=>'#periode','icon'=>'event_note',   'label'=>'Periode PPDB'],
                    ['href'=>'#alur',   'icon'=>'route',        'label'=>'Alur PPDB'],
                    ['href'=>'#syarat', 'icon'=>'checklist',    'label'=>'Syarat'],
                    ['href'=>'#faq',    'icon'=>'help',         'label'=>'FAQ'],
                ] as $item)
                <a href="{{ $item['href'] }}"
                    onclick="document.getElementById('mobile-drawer').checked = false;"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                    style="color:rgba(255,255,255,0.75);"
                    onmouseover="this.style.backgroundColor='rgba(1,139,62,0.25)';this.style.color='white';"
                    onmouseout="this.style.backgroundColor='transparent';this.style.color='rgba(255,255,255,0.75)';">
                    <span class="material-symbols-outlined text-xl" style="color:#018B3E;">{{ $item['icon'] }}</span>
                    {{ $item['label'] }}
                </a>
                @endforeach
            </nav>

            <div class="px-4 pb-8 pt-2 border-t" style="border-color:rgba(255,255,255,0.08);">
                <a href="{{ route('register') }}"
                    class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold text-sm transition-all hover:brightness-110"
                    style="background-color:#F6CB04; color:#0f2318;">
                    <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-bold text-sm mt-3 transition-all"
                    style="border:1.5px solid rgba(1,139,62,0.5); color:rgba(255,255,255,0.75);"
                    onmouseover="this.style.borderColor='#018B3E';this.style.color='white';"
                    onmouseout="this.style.borderColor='rgba(1,139,62,0.5)';this.style.color='rgba(255,255,255,0.75)';">
                    <span class="material-symbols-outlined text-[20px]">login</span>
                    Login
                </a>
            </div>

        </div>
    </div>

</div>{{-- end drawer --}}

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 700,
        easing: 'ease-out-cubic',
        once: true,
        offset: 60,
    });
</script>
@endpush

@endsection