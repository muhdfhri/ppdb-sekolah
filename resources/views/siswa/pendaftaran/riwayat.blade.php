@extends('layouts.siswa')

@section('title', 'Riwayat Pendaftaran - PPDB SMK NU II Medan')
@section('breadcrumb_parent', 'Pendaftaran')
@section('breadcrumb', 'Riwayat')
@section('header_sub', $pendaftaran?->nomor_pendaftaran ?? 'Belum Ada Pendaftaran')

@section('content')

@if(!$pendaftaran)
    {{-- ── Empty State ─────────────────────────────────────────── --}}
    <div class="max-w-5xl w-full">
        <div class="bg-white rounded-2xl lg:rounded-3xl p-8 lg:p-16 shadow-sm border border-slate-200 text-center">
            <div class="flex justify-center mb-6">
                <div class="size-24 rounded-full flex items-center justify-center" style="background-color:rgba(1,139,62,0.08);">
                    <span class="material-symbols-outlined text-5xl" style="color:#018B3E;">inbox</span>
                </div>
            </div>
            <h2 class="text-xl lg:text-2xl font-black text-slate-800 mb-2">Belum Ada Pendaftaran</h2>
            <p class="text-sm text-slate-400 mb-8 max-w-sm mx-auto">
                Anda belum memiliki riwayat pendaftaran. Mulai pendaftaran sekarang untuk melanjutkan proses PPDB.
            </p>
            <a href="{{ route('siswa.pendaftaran.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white transition hover:opacity-90"
                style="background-color:#018B3E;">
                <span class="material-symbols-outlined text-base">add_circle</span>
                Mulai Pendaftaran
            </a>
        </div>
    </div>

@else
    {{-- ── Ada Data Pendaftaran ─────────────────────────────────── --}}
    @php
        $siswa    = $pendaftaran->siswa;
        $sekolah  = $pendaftaran->sekolahAsal;
        $jurusan  = $pendaftaran->jurusan;
        $jurusan2 = $pendaftaran->jurusanPilihan2;
        $ayah     = $pendaftaran->orangTua->firstWhere('jenis', 'ayah');
        $ibu      = $pendaftaran->orangTua->firstWhere('jenis', 'ibu');

        $statusCfg = [
            'draft'               => ['label' => 'Draft',               'cls' => 'badge-ghost',   'dot' => '#94a3b8'],
            'menunggu_pembayaran' => ['label' => 'Menunggu Pembayaran',  'cls' => 'badge-warning', 'dot' => '#d97706'],
            'menunggu_verifikasi' => ['label' => 'Menunggu Verifikasi',  'cls' => 'badge-warning', 'dot' => '#d97706'],
            'terverifikasi'       => ['label' => 'Terverifikasi',        'cls' => 'badge-success', 'dot' => '#018B3E'],
            'diterima'            => ['label' => 'Diterima',             'cls' => 'badge-success', 'dot' => '#018B3E'],
            'cadangan'            => ['label' => 'Cadangan',             'cls' => 'badge-info',    'dot' => '#7c3aed'],
            'ditolak'             => ['label' => 'Tidak Diterima',       'cls' => 'badge-error',   'dot' => '#dc2626'],
        ];
        $sc = $statusCfg[$pendaftaran->status] ?? $statusCfg['draft'];

        $dokumenList = [
            'ijazah'           => ['label' => 'Ijazah / SKL',     'icon' => 'description'],
            'kartu_keluarga'   => ['label' => 'Kartu Keluarga',   'icon' => 'group'],
            'akte_kelahiran'   => ['label' => 'Akta Kelahiran',   'icon' => 'badge'],
            'pas_foto'         => ['label' => 'Pas Foto',         'icon' => 'photo_camera'],
            'bukti_pembayaran' => ['label' => 'Bukti Pembayaran', 'icon' => 'receipt'],
            'kip'              => ['label' => 'KIP / KPS / PKH',  'icon' => 'card_membership'],
        ];
        $dokumenMap = $pendaftaran->dokumen->keyBy('jenis_dokumen');

        $penghasilanMap = [
            'kurang_1jt' => '< Rp 1.000.000',
            '1jt_3jt'   => 'Rp 1 – 3 juta',
            '3jt_5jt'   => 'Rp 3 – 5 juta',
            '5jt_10jt'  => 'Rp 5 – 10 juta',
            'lebih_10jt'=> '> Rp 10 juta',
        ];

        $steps = [
            1 => ['done' => (bool)$siswa,   'label' => 'Data Pribadi'],
            2 => ['done' => (bool)$sekolah, 'label' => 'Sekolah Asal'],
            3 => ['done' => $pendaftaran->orangTua->isNotEmpty(), 'label' => 'Orang Tua'],
            4 => ['done' => (bool)$jurusan, 'label' => 'Jurusan'],
            5 => ['done' => $dokumenMap->isNotEmpty(), 'label' => 'Dokumen'],
        ];
        $stepsDone = collect($steps)->filter(fn($s) => $s['done'])->count();
        $progres   = round(($stepsDone / 5) * 100);
    @endphp

    <div class="max-w-5xl w-full space-y-6">

        {{-- ── Status Card ─────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-4 lg:mb-6">
                <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Status Pendaftaran Anda</h2>
                <span class="px-3 lg:px-4 py-1.5 lg:py-2 rounded-full text-xs lg:text-sm font-bold flex items-center gap-2"
                    style="background-color:{{ $pendaftaran->status === 'draft' ? 'rgba(1,139,62,0.1)' : ($pendaftaran->status === 'menunggu_verifikasi' ? 'rgba(246,203,4,0.1)' : 'rgba(1,139,62,0.1)') }}; color:{{ $pendaftaran->status === 'draft' ? '#64748b' : ($pendaftaran->status === 'menunggu_verifikasi' ? '#b45309' : '#018B3E') }};">
                    <span class="w-1.5 lg:w-2 h-1.5 lg:h-2 rounded-full"
                        style="background-color:{{ $pendaftaran->status === 'draft' ? '#64748b' : ($pendaftaran->status === 'menunggu_verifikasi' ? '#F6CB04' : '#018B3E') }};"></span>
                    {{ $pendaftaran->label_status }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <div class="space-y-3 lg:space-y-4">
                    <div>
                        <p class="text-[10px] lg:text-xs text-slate-400 font-semibold uppercase tracking-wider">Nomor Pendaftaran</p>
                        <p class="text-base lg:text-lg font-bold text-[#018B3E]">{{ $pendaftaran->nomor_pendaftaran }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] lg:text-xs text-slate-400 font-semibold uppercase tracking-wider">Tanggal Daftar</p>
                        <p class="text-sm lg:text-base font-semibold text-slate-700">{{ $pendaftaran->tanggal_daftar->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="space-y-3 lg:space-y-4">
                    <div>
                        <p class="text-[10px] lg:text-xs text-slate-400 font-semibold uppercase tracking-wider">Jurusan Pilihan</p>
                        <p class="text-sm lg:text-base font-semibold text-slate-700">{{ $pendaftaran->jurusan->nama_jurusan ?? 'Belum dipilih' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] lg:text-xs text-slate-400 font-semibold uppercase tracking-wider">Langkah Terakhir</p>
                        <p class="text-sm lg:text-base font-semibold text-slate-700">Langkah {{ $pendaftaran->step_terakhir }} dari 5</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Summary Strip ────────────────────────────────────── --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach([
                ['icon' => 'calendar_today', 'label' => 'Terdaftar',   'value' => $pendaftaran->tanggal_daftar->translatedFormat('d M Y')],
                ['icon' => 'school',         'label' => 'Jurusan',      'value' => $jurusan?->kode_jurusan ?? '—'],
                ['icon' => 'checklist',      'label' => 'Step Selesai', 'value' => $stepsDone . ' / 5'],
                ['icon' => 'folder_open',    'label' => 'Dokumen',      'value' => $dokumenMap->count() . ' / 6'],
            ] as $stat)
            <div class="bg-white rounded-xl p-4 border border-slate-100 text-center">
                <span class="material-symbols-outlined text-xl mb-1 block" style="color:#018B3E;">{{ $stat['icon'] }}</span>
                <p class="text-xs text-slate-400 font-medium">{{ $stat['label'] }}</p>
                <p class="text-base font-black text-slate-800 mt-0.5">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- ── Main Grid ────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom kiri: step 1-3 --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- ── STEP 1: Data Pribadi ─────────────────────── --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 flex items-center gap-3 border-b border-slate-100">
                        <div class="size-8 rounded-lg flex items-center justify-center font-black text-xs text-white shrink-0"
                            style="background-color:{{ $siswa ? '#018B3E' : '#e2e8f0' }};">
                            {{ $siswa ? '✓' : '1' }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 text-sm">Data Pribadi</h3>
                        </div>
                        @if(!$siswa)
                            <a href="{{ route('siswa.pendaftaran.step1') }}"
                                class="btn btn-xs btn-outline text-[10px]" style="border-color:#018B3E; color:#018B3E;">
                                Lengkapi
                            </a>
                        @endif
                    </div>
                    @if($siswa)
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                        @foreach([
                            ['label' => 'NIK',            'value' => $siswa->nik ?? '—'],
                            ['label' => 'Nama Lengkap',   'value' => $siswa->nama_lengkap ?? '—'],
                            ['label' => 'Tempat Lahir',   'value' => $siswa->tempat_lahir ?? '—'],
                            ['label' => 'Tanggal Lahir',  'value' => $siswa->tanggal_lahir?->translatedFormat('d M Y') ?? '—'],
                            ['label' => 'Jenis Kelamin',  'value' => $siswa->jenis_kelamin ?? '—'],
                            ['label' => 'Agama',          'value' => $siswa->agama ?? '—'],
                            ['label' => 'No. Telepon',    'value' => $siswa->no_telepon ?? '—'],
                            ['label' => 'Email',          'value' => $siswa->email ?? '—'],
                            ['label' => 'Alamat Lengkap', 'value' => $siswa->alamat_lengkap ?? '—', 'full' => true],
                        ] as $f)
                        <div class="{{ ($f['full'] ?? false) ? 'sm:col-span-2' : '' }}">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $f['label'] }}</p>
                            <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $f['value'] }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="px-6 py-8 text-center">
                        <span class="material-symbols-outlined text-3xl text-slate-200 block mb-2">person_off</span>
                        <p class="text-sm text-slate-400">Belum diisi</p>
                    </div>
                    @endif
                </div>

                {{-- ── STEP 2: Sekolah Asal ─────────────────────── --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 flex items-center gap-3 border-b border-slate-100">
                        <div class="size-8 rounded-lg flex items-center justify-center font-black text-xs text-white shrink-0"
                            style="background-color:{{ $sekolah ? '#018B3E' : '#e2e8f0' }};">
                            {{ $sekolah ? '✓' : '2' }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 text-sm">Sekolah Asal</h3>
                        </div>
                        @if(!$sekolah)
                            <a href="{{ route('siswa.pendaftaran.step2') }}"
                                class="btn btn-xs btn-outline text-[10px]" style="border-color:#018B3E; color:#018B3E;">
                                Lengkapi
                            </a>
                        @endif
                    </div>
                    @if($sekolah)
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                        @foreach([
                            ['label' => 'Nama Sekolah',   'value' => $sekolah->nama_sekolah ?? '—', 'full' => true],
                            ['label' => 'NISN',            'value' => $sekolah->nisn ?? '—'],
                            ['label' => 'Tahun Lulus',     'value' => $sekolah->tahun_lulus ?? '—'],
                            ['label' => 'Nilai Rata-rata', 'value' => $sekolah->nilai_rata_rata ? number_format($sekolah->nilai_rata_rata, 2) : '—'],
                            ['label' => 'Alamat Sekolah',  'value' => $sekolah->alamat_sekolah ?? '—', 'full' => true],
                        ] as $f)
                        <div class="{{ ($f['full'] ?? false) ? 'sm:col-span-2' : '' }}">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $f['label'] }}</p>
                            <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $f['value'] }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="px-6 py-8 text-center">
                        <span class="material-symbols-outlined text-3xl text-slate-200 block mb-2">school</span>
                        <p class="text-sm text-slate-400">Belum diisi</p>
                    </div>
                    @endif
                </div>

                {{-- ── STEP 3: Orang Tua ────────────────────────── --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 flex items-center gap-3 border-b border-slate-100">
                        <div class="size-8 rounded-lg flex items-center justify-center font-black text-xs text-white shrink-0"
                            style="background-color:{{ $pendaftaran->orangTua->isNotEmpty() ? '#018B3E' : '#e2e8f0' }};">
                            {{ $pendaftaran->orangTua->isNotEmpty() ? '✓' : '3' }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 text-sm">Data Orang Tua</h3>
                        </div>
                        @if($pendaftaran->orangTua->isEmpty())
                            <a href="{{ route('siswa.pendaftaran.step3') }}"
                                class="btn btn-xs btn-outline text-[10px]" style="border-color:#018B3E; color:#018B3E;">
                                Lengkapi
                            </a>
                        @endif
                    </div>
                    @if($pendaftaran->orangTua->isNotEmpty())
                    <div class="divide-y divide-slate-50">
                        @foreach(['ayah' => ['label' => 'Ayah', 'model' => $ayah], 'ibu' => ['label' => 'Ibu', 'model' => $ibu]] as $jenis => $info)
                        @php $ortu = $info['model']; @endphp
                        <div class="p-6">
                            <p class="text-xs font-extrabold uppercase tracking-widest mb-4" style="color:#018B3E;">{{ $info['label'] }}</p>
                            @if($ortu)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                                @foreach([
                                    ['label' => 'Nama Lengkap', 'value' => $ortu->nama_lengkap ?? '—'],
                                    ['label' => 'NIK',           'value' => $ortu->nik ?? '—'],
                                    ['label' => 'Tempat Lahir',  'value' => $ortu->tempat_lahir ?? '—'],
                                    ['label' => 'Tanggal Lahir', 'value' => $ortu->tanggal_lahir?->translatedFormat('d M Y') ?? '—'],
                                    ['label' => 'Pekerjaan',     'value' => $ortu->pekerjaan ?? '—'],
                                    ['label' => 'Penghasilan',   'value' => $penghasilanMap[$ortu->penghasilan ?? ''] ?? ($ortu->penghasilan ?? '—')],
                                    ['label' => 'No. Telepon',   'value' => $ortu->no_telepon ?? '—'],
                                    ['label' => 'Alamat',        'value' => $ortu->alamat ?? '—', 'full' => true],
                                ] as $f)
                                <div class="{{ ($f['full'] ?? false) ? 'sm:col-span-2' : '' }}">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $f['label'] }}</p>
                                    <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $f['value'] }}</p>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-sm text-slate-400 italic">Data {{ $info['label'] }} belum diisi</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="px-6 py-8 text-center">
                        <span class="material-symbols-outlined text-3xl text-slate-200 block mb-2">family_restroom</span>
                        <p class="text-sm text-slate-400">Belum diisi</p>
                    </div>
                    @endif
                </div>

            </div>

            {{-- Kolom kanan: step 4-5 + riwayat verifikasi --}}
            <div class="space-y-5">

                {{-- ── STEP 4: Jurusan ──────────────────────────── --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 flex items-center gap-3 border-b border-slate-100">
                        <div class="size-8 rounded-lg flex items-center justify-center font-black text-xs text-white shrink-0"
                            style="background-color:{{ $jurusan ? '#018B3E' : '#e2e8f0' }};">
                            {{ $jurusan ? '✓' : '4' }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 text-sm">Pilihan Jurusan</h3>
                        </div>
                        @if(!$jurusan)
                            <a href="{{ route('siswa.pendaftaran.step4') }}"
                                class="btn btn-xs btn-outline text-[10px]" style="border-color:#018B3E; color:#018B3E;">
                                Lengkapi
                            </a>
                        @endif
                    </div>
                    @if($jurusan)
                    <div class="p-5 space-y-3">
                        <div class="p-3 rounded-xl border" style="background-color:rgba(1,139,62,0.05); border-color:rgba(1,139,62,0.2);">
                            <p class="text-[10px] font-bold uppercase tracking-wider mb-1" style="color:#018B3E;">Pilihan 1</p>
                            <p class="text-sm font-black text-slate-800">{{ $jurusan->nama_jurusan }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold text-white" style="background-color:#018B3E;">
                                {{ $jurusan->kode_jurusan }}
                            </span>
                        </div>
                        @if($jurusan2)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Pilihan 2</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $jurusan2->nama_jurusan }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600">
                                {{ $jurusan2->kode_jurusan }}
                            </span>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="px-6 py-8 text-center">
                        <span class="material-symbols-outlined text-3xl text-slate-200 block mb-2">school</span>
                        <p class="text-sm text-slate-400">Belum dipilih</p>
                    </div>
                    @endif
                </div>

                {{-- ── STEP 5: Dokumen ──────────────────────────── --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 flex items-center gap-3 border-b border-slate-100">
                        <div class="size-8 rounded-lg flex items-center justify-center font-black text-xs text-white shrink-0"
                            style="background-color:{{ $dokumenMap->isNotEmpty() ? '#018B3E' : '#e2e8f0' }};">
                            {{ $dokumenMap->isNotEmpty() ? '✓' : '5' }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 text-sm">Dokumen</h3>
                        </div>
                        @if($dokumenMap->isEmpty())
                            <a href="{{ route('siswa.pendaftaran.step5') }}"
                                class="btn btn-xs btn-outline text-[10px]" style="border-color:#018B3E; color:#018B3E;">
                                Upload
                            </a>
                        @endif
                    </div>
                    <div class="p-4 space-y-2">
                        @foreach($dokumenList as $key => $info)
                        @php $dok = $dokumenMap->get($key); @endphp
                        <div class="flex items-center gap-3 p-2.5 rounded-xl transition-colors
                            {{ $dok ? 'bg-[#018B3E]/5' : 'bg-slate-50' }}">
                            <span class="material-symbols-outlined text-lg shrink-0"
                                style="color:{{ $dok ? '#018B3E' : '#cbd5e1' }};">
                                {{ $dok ? 'check_circle' : 'radio_button_unchecked' }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold truncate {{ $dok ? 'text-slate-700' : 'text-slate-400' }}">
                                    {{ $info['label'] }}
                                </p>
                                @if($dok)
                                <p class="text-[10px] text-slate-400 truncate">{{ $dok->nama_file }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Riwayat Verifikasi ────────────────────────── --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 flex items-center gap-3 border-b border-slate-100">
                        <span class="material-symbols-outlined text-lg" style="color:#018B3E;">history</span>
                        <h3 class="font-bold text-slate-900 text-sm">Riwayat Verifikasi</h3>
                    </div>
                    <div class="p-5">
                        @forelse($pendaftaran->verifikasiLog as $log)
                        <div class="flex gap-3 {{ !$loop->last ? 'mb-4 pb-4 border-b border-slate-50' : '' }}">
                            <div class="size-7 rounded-full flex items-center justify-center shrink-0 mt-0.5"
                                style="background-color:rgba(1,139,62,0.1);">
                                <span class="material-symbols-outlined text-sm" style="color:#018B3E;">manage_accounts</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-800">{{ $log->admin->nama_lengkap ?? 'Admin' }}</p>
                                <p class="text-[10px] text-slate-500 mt-0.5">
                                    <span class="text-slate-400">{{ $log->status_sebelum ?? '—' }}</span>
                                    <span class="material-symbols-outlined text-xs align-middle">arrow_forward</span>
                                    <span class="font-bold" style="color:#018B3E;">{{ $log->status_sesudah }}</span>
                                </p>
                                @if($log->catatan)
                                <p class="text-[10px] text-slate-400 mt-1 italic">"{{ $log->catatan }}"</p>
                                @endif
                                <p class="text-[10px] text-slate-300 mt-1">
                                    {{ $log->created_at?->translatedFormat('d M Y, H:i') ?? '—' }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <span class="material-symbols-outlined text-3xl text-slate-200 block mb-2">history</span>
                            <p class="text-xs text-slate-400">Belum ada riwayat verifikasi</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

@endif
@endsection