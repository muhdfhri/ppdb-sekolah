{{-- resources/views/siswa/pendaftaran/step5.blade.php --}}
@extends('layouts.app')

@section('title', 'Langkah 5 - Upload Dokumen | PPDB SMK NU II Medan')

@section('content')
<div class="min-h-screen bg-[#F6F4F7] font-['Public Sans']">

    {{-- ================================================================
    MOBILE HEADER (hanya muncul di layar kecil)
    ================================================================ --}}
    <div class="lg:hidden bg-white sticky top-0 z-50 px-4 py-3 flex items-center justify-between border-b border-slate-200">
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
            <div class="w-8 h-8 rounded-full bg-[#018B3E]/10 border-2 border-[#018B3E]/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-sm text-[#018B3E]">person</span>
            </div>
        </div>
    </div>

    {{-- ================================================================
    MOBILE SIDEBAR (hidden by default)
    ================================================================ --}}
    <div id="mobile-sidebar" class="hidden fixed inset-0 z-50 lg:hidden">
        <div class="absolute inset-0 bg-black/50" onclick="toggleMobileSidebar()"></div>
        <aside class="absolute left-0 top-0 h-full w-72 bg-white flex flex-col p-6 shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0">
                        <img src="{{ asset('images/logo-smk.png') }}" 
                            alt="Logo SMK NU II Medan"
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

            {{-- Nav Links Mobile --}}
            <nav class="flex flex-col gap-2 flex-1">
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-[#018B3E]/5 transition-all">
                    <span class="material-symbols-outlined">home</span>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('siswa.pendaftaran.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-white bg-[#018B3E] transition-all">
                    <span class="material-symbols-outlined">assignment</span>
                    <span class="font-medium">Pendaftaran</span>
                </a>

                <div class="mt-4 pt-4 border-t border-slate-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all">
                            <span class="material-symbols-outlined">logout</span>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            {{-- Cetak Bukti Mobile --}}
            <button class="w-full bg-[#F6CB04] text-[#0f2318] font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 transition-all hover:brightness-95 mt-4">
                <span class="material-symbols-outlined">print</span>
                <span>Cetak Bukti</span>
            </button>
        </aside>
    </div>

    {{-- ================================================================
    DESKTOP SIDEBAR (hidden di mobile)
    ================================================================ --}}
    <aside class="hidden lg:flex w-72 bg-white flex-col justify-between p-6 sticky top-0 h-screen shrink-0 float-left"
        style="border-right: 1px solid rgba(1,139,62,0.1);">
        {{-- Logo --}}
        <div class="flex flex-col gap-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0">
                    <img src="{{ asset('images/logo-smk.png') }}" 
                        alt="Logo SMK NU II Medan"
                        class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="font-bold text-sm leading-tight text-[#018B3E]">SMK NU II<br />Medan</h1>
                    <p class="text-xs text-slate-500">Portal PPDB</p>
                </div>
            </div>

            {{-- Nav Links Desktop --}}
            <nav class="flex flex-col gap-2">
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-[#018B3E]/5 transition-all">
                    <span class="material-symbols-outlined">home</span>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('siswa.pendaftaran.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-white bg-[#018B3E] transition-all">
                    <span class="material-symbols-outlined">assignment</span>
                    <span class="font-medium">Pendaftaran</span>
                </a>

                <div class="mt-4 pt-4 border-t border-slate-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all">
                            <span class="material-symbols-outlined">logout</span>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        {{-- Cetak Bukti Desktop --}}
        <button class="w-full bg-[#F6CB04] text-[#0f2318] font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 transition-all hover:brightness-95">
            <span class="material-symbols-outlined">print</span>
            <span>Cetak Bukti</span>
        </button>
    </aside>

    {{-- ================================================================
    MAIN CONTENT (flexible width)
    ================================================================ --}}
    <main class="lg:ml-72 min-h-screen flex flex-col">
        {{-- Desktop Header (hidden di mobile) --}}
        <header class="hidden lg:flex h-20 bg-white px-8 items-center justify-between" style="border-bottom: 1px solid #f1f5f9;">
            <div class="flex items-center gap-2">
                <span class="text-slate-400 font-medium">Pendaftaran</span>
                <span class="material-symbols-outlined text-slate-300">chevron_right</span>
                <span class="font-semibold text-[#018B3E]">Langkah 5: Upload Dokumen</span>
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
                    <div class="w-10 h-10 rounded-full bg-[#018B3E]/10 border-2 border-[#018B3E]/20 flex items-center justify-center overflow-hidden">
                        @if(auth()->user()->foto)
                            <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-xl text-[#018B3E]">person</span>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <div class="p-4 sm:p-6 lg:p-8 space-y-6 lg:space-y-8 max-w-7xl w-full">

            {{-- Stepper --}}
            @include('siswa.partials.stepper', ['currentStep' => 5])

            {{-- Alerts --}}
            @if(session('success'))
                <div class="flex items-start gap-3 p-4 rounded-xl text-sm font-medium bg-green-50 border border-green-200 text-green-700">
                    <span class="material-symbols-outlined shrink-0 mt-0.5 text-base">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="flex items-start gap-3 p-4 rounded-xl text-sm bg-red-50 border border-red-200 text-red-600">
                    <span class="material-symbols-outlined shrink-0 mt-0.5 text-base">error</span>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 shadow-sm border border-slate-200">
                <div class="mb-6 lg:mb-8">
                    <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Registrasi Siswa Baru</h2>
                    <p class="text-sm lg:text-base text-slate-500 mt-1">Langkah 5: Upload dokumen persyaratan</p>
                </div>

                <form action="{{ route('siswa.pendaftaran.step5.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    {{-- ============================================================
                    DOKUMEN PERSYARATAN
                    ============================================================ --}}
                    <div class="space-y-4">
                        {{-- Ijazah --}}
                        @php $uploaded = $dokumen['ijazah'] ?? null; @endphp
                        <div class="p-4 lg:p-5 rounded-xl border-2 transition-all"
                             id="wrap-ijazah"
                             style="border-color:{{ $uploaded ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $uploaded ? 'rgba(1,139,62,0.04)' : '#f8fafc' }};">
                            <div class="flex items-start gap-3 lg:gap-4">
                                <div class="size-10 lg:size-12 rounded-xl flex items-center justify-center shrink-0 text-white" style="background-color:#018B3E;">
                                    <span class="material-symbols-outlined text-xl lg:text-2xl">description</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm lg:text-base font-semibold text-slate-900">
                                        Ijazah / SKL <span class="text-red-500">*</span>
                                    </p>
                                    <p class="text-[10px] lg:text-xs text-slate-500 mt-0.5">Scan ijazah/SKL yang dilegalisir</p>
                                    @if($uploaded)
                                        <div class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            <span class="truncate max-w-[150px] lg:max-w-[200px]">{{ $uploaded->nama_file }}</span>
                                        </div>
                                    @endif
                                    <label class="mt-2 lg:mt-3 flex items-center gap-2 lg:gap-3 cursor-pointer group" for="file-ijazah">
                                        <div class="flex-1 px-3 lg:px-4 py-2 lg:py-2.5 rounded-lg border-2 border-dashed text-xs lg:text-sm text-slate-400 transition-all flex items-center gap-2"
                                             style="border-color:rgba(1,139,62,0.25);">
                                            <span class="material-symbols-outlined text-sm lg:text-base">upload_file</span>
                                            <span id="text-ijazah" class="truncate max-w-[120px] lg:max-w-[200px]">
                                                {{ $uploaded ? 'Klik untuk ganti file' : 'Klik untuk pilih file' }}
                                            </span>
                                        </div>
                                        <input id="file-ijazah" type="file" name="ijazah" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" {{ !$uploaded ? 'required' : '' }} onchange="handleFileSelect(this, 'ijazah')">
                                    </label>
                                    @error('ijazah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                @if($uploaded)
                                    <span class="shrink-0 inline-flex items-center gap-1 text-[10px] lg:text-xs font-bold px-2 py-1 rounded-full"
                                          style="background-color:rgba(1,139,62,0.1); color:#018B3E;">
                                        <span class="material-symbols-outlined text-xs lg:text-sm">check_circle</span>
                                        <span class="hidden sm:inline">Terupload</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Kartu Keluarga --}}
                        @php $uploaded = $dokumen['kartu_keluarga'] ?? null; @endphp
                        <div class="p-4 lg:p-5 rounded-xl border-2 transition-all"
                             id="wrap-kartu_keluarga"
                             style="border-color:{{ $uploaded ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $uploaded ? 'rgba(1,139,62,0.04)' : '#f8fafc' }};">
                            <div class="flex items-start gap-3 lg:gap-4">
                                <div class="size-10 lg:size-12 rounded-xl flex items-center justify-center shrink-0 text-white" style="background-color:#018B3E;">
                                    <span class="material-symbols-outlined text-xl lg:text-2xl">group</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm lg:text-base font-semibold text-slate-900">
                                        Kartu Keluarga <span class="text-red-500">*</span>
                                    </p>
                                    <p class="text-[10px] lg:text-xs text-slate-500 mt-0.5">Scan KK terbaru (semua anggota terlihat)</p>
                                    @if($uploaded)
                                        <div class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            <span class="truncate max-w-[150px] lg:max-w-[200px]">{{ $uploaded->nama_file }}</span>
                                        </div>
                                    @endif
                                    <label class="mt-2 lg:mt-3 flex items-center gap-2 lg:gap-3 cursor-pointer group" for="file-kartu_keluarga">
                                        <div class="flex-1 px-3 lg:px-4 py-2 lg:py-2.5 rounded-lg border-2 border-dashed text-xs lg:text-sm text-slate-400 transition-all flex items-center gap-2"
                                             style="border-color:rgba(1,139,62,0.25);">
                                            <span class="material-symbols-outlined text-sm lg:text-base">upload_file</span>
                                            <span id="text-kartu_keluarga" class="truncate max-w-[120px] lg:max-w-[200px]">
                                                {{ $uploaded ? 'Klik untuk ganti file' : 'Klik untuk pilih file' }}
                                            </span>
                                        </div>
                                        <input id="file-kartu_keluarga" type="file" name="kartu_keluarga" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" {{ !$uploaded ? 'required' : '' }} onchange="handleFileSelect(this, 'kartu_keluarga')">
                                    </label>
                                    @error('kartu_keluarga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                @if($uploaded)
                                    <span class="shrink-0 inline-flex items-center gap-1 text-[10px] lg:text-xs font-bold px-2 py-1 rounded-full"
                                          style="background-color:rgba(1,139,62,0.1); color:#018B3E;">
                                        <span class="material-symbols-outlined text-xs lg:text-sm">check_circle</span>
                                        <span class="hidden sm:inline">Terupload</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Akte Kelahiran --}}
                        @php $uploaded = $dokumen['akte_kelahiran'] ?? null; @endphp
                        <div class="p-4 lg:p-5 rounded-xl border-2 transition-all"
                             id="wrap-akte_kelahiran"
                             style="border-color:{{ $uploaded ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $uploaded ? 'rgba(1,139,62,0.04)' : '#f8fafc' }};">
                            <div class="flex items-start gap-3 lg:gap-4">
                                <div class="size-10 lg:size-12 rounded-xl flex items-center justify-center shrink-0 text-white" style="background-color:#018B3E;">
                                    <span class="material-symbols-outlined text-xl lg:text-2xl">badge</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm lg:text-base font-semibold text-slate-900">
                                        Akta Kelahiran <span class="text-red-500">*</span>
                                    </p>
                                    <p class="text-[10px] lg:text-xs text-slate-500 mt-0.5">Scan akta kelahiran asli</p>
                                    @if($uploaded)
                                        <div class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            <span class="truncate max-w-[150px] lg:max-w-[200px]">{{ $uploaded->nama_file }}</span>
                                        </div>
                                    @endif
                                    <label class="mt-2 lg:mt-3 flex items-center gap-2 lg:gap-3 cursor-pointer group" for="file-akte_kelahiran">
                                        <div class="flex-1 px-3 lg:px-4 py-2 lg:py-2.5 rounded-lg border-2 border-dashed text-xs lg:text-sm text-slate-400 transition-all flex items-center gap-2"
                                             style="border-color:rgba(1,139,62,0.25);">
                                            <span class="material-symbols-outlined text-sm lg:text-base">upload_file</span>
                                            <span id="text-akte_kelahiran" class="truncate max-w-[120px] lg:max-w-[200px]">
                                                {{ $uploaded ? 'Klik untuk ganti file' : 'Klik untuk pilih file' }}
                                            </span>
                                        </div>
                                        <input id="file-akte_kelahiran" type="file" name="akte_kelahiran" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" {{ !$uploaded ? 'required' : '' }} onchange="handleFileSelect(this, 'akte_kelahiran')">
                                    </label>
                                    @error('akte_kelahiran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                @if($uploaded)
                                    <span class="shrink-0 inline-flex items-center gap-1 text-[10px] lg:text-xs font-bold px-2 py-1 rounded-full"
                                          style="background-color:rgba(1,139,62,0.1); color:#018B3E;">
                                        <span class="material-symbols-outlined text-xs lg:text-sm">check_circle</span>
                                        <span class="hidden sm:inline">Terupload</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Pas Foto --}}
                        @php $uploaded = $dokumen['pas_foto'] ?? null; @endphp
                        <div class="p-4 lg:p-5 rounded-xl border-2 transition-all"
                             id="wrap-pas_foto"
                             style="border-color:{{ $uploaded ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $uploaded ? 'rgba(1,139,62,0.04)' : '#f8fafc' }};">
                            <div class="flex items-start gap-3 lg:gap-4">
                                <div class="size-10 lg:size-12 rounded-xl flex items-center justify-center shrink-0 text-white" style="background-color:#018B3E;">
                                    <span class="material-symbols-outlined text-xl lg:text-2xl">photo_camera</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm lg:text-base font-semibold text-slate-900">
                                        Pas Foto 3x4 <span class="text-red-500">*</span>
                                    </p>
                                    <p class="text-[10px] lg:text-xs text-slate-500 mt-0.5">Foto formal, latar merah, format JPG/PNG</p>
                                    @if($uploaded)
                                        <div class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            <span class="truncate max-w-[150px] lg:max-w-[200px]">{{ $uploaded->nama_file }}</span>
                                        </div>
                                    @endif
                                    <label class="mt-2 lg:mt-3 flex items-center gap-2 lg:gap-3 cursor-pointer group" for="file-pas_foto">
                                        <div class="flex-1 px-3 lg:px-4 py-2 lg:py-2.5 rounded-lg border-2 border-dashed text-xs lg:text-sm text-slate-400 transition-all flex items-center gap-2"
                                             style="border-color:rgba(1,139,62,0.25);">
                                            <span class="material-symbols-outlined text-sm lg:text-base">upload_file</span>
                                            <span id="text-pas_foto" class="truncate max-w-[120px] lg:max-w-[200px]">
                                                {{ $uploaded ? 'Klik untuk ganti file' : 'Klik untuk pilih file' }}
                                            </span>
                                        </div>
                                        <input id="file-pas_foto" type="file" name="pas_foto" accept=".jpg,.jpeg,.png" class="sr-only" {{ !$uploaded ? 'required' : '' }} onchange="handleFileSelect(this, 'pas_foto')">
                                    </label>
                                    @error('pas_foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                @if($uploaded)
                                    <span class="shrink-0 inline-flex items-center gap-1 text-[10px] lg:text-xs font-bold px-2 py-1 rounded-full"
                                          style="background-color:rgba(1,139,62,0.1); color:#018B3E;">
                                        <span class="material-symbols-outlined text-xs lg:text-sm">check_circle</span>
                                        <span class="hidden sm:inline">Terupload</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- KIP (Opsional) --}}
                        @php $uploaded = $dokumen['kip'] ?? null; @endphp
                        <div class="p-4 lg:p-5 rounded-xl border-2 transition-all"
                             id="wrap-kip"
                             style="border-color:{{ $uploaded ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $uploaded ? 'rgba(1,139,62,0.04)' : '#f8fafc' }};">
                            <div class="flex items-start gap-3 lg:gap-4">
                                <div class="size-10 lg:size-12 rounded-xl flex items-center justify-center shrink-0 text-white" style="background-color:#018B3E;">
                                    <span class="material-symbols-outlined text-xl lg:text-2xl">card_membership</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm lg:text-base font-semibold text-slate-900">
                                        KIP / KPS / PKH
                                    </p>
                                    <p class="text-[10px] lg:text-xs text-slate-500 mt-0.5">Jika memiliki kartu bantuan pemerintah (opsional)</p>
                                    @if($uploaded)
                                        <div class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            <span class="truncate max-w-[150px] lg:max-w-[200px]">{{ $uploaded->nama_file }}</span>
                                        </div>
                                    @endif
                                    <label class="mt-2 lg:mt-3 flex items-center gap-2 lg:gap-3 cursor-pointer group" for="file-kip">
                                        <div class="flex-1 px-3 lg:px-4 py-2 lg:py-2.5 rounded-lg border-2 border-dashed text-xs lg:text-sm text-slate-400 transition-all flex items-center gap-2"
                                             style="border-color:rgba(1,139,62,0.25);">
                                            <span class="material-symbols-outlined text-sm lg:text-base">upload_file</span>
                                            <span id="text-kip" class="truncate max-w-[120px] lg:max-w-[200px]">
                                                {{ $uploaded ? 'Klik untuk ganti file' : 'Klik untuk pilih file' }}
                                            </span>
                                        </div>
                                        <input id="file-kip" type="file" name="kip" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" onchange="handleFileSelect(this, 'kip')">
                                    </label>
                                    @error('kip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                @if($uploaded)
                                    <span class="shrink-0 inline-flex items-center gap-1 text-[10px] lg:text-xs font-bold px-2 py-1 rounded-full"
                                          style="background-color:rgba(1,139,62,0.1); color:#018B3E;">
                                        <span class="material-symbols-outlined text-xs lg:text-sm">check_circle</span>
                                        <span class="hidden sm:inline">Terupload</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ============================================================
                    SECTION BUKTI PEMBAYARAN (TERPISAH & MENONJOL)
                    ============================================================ --}}
                    <div class="pt-6 mt-6 border-t-2 border-dashed border-[#018B3E]/30">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-[#018B3E] flex items-center justify-center text-white">
                                <span class="material-symbols-outlined text-xl">receipt</span>
                            </div>
                            <div>
                                <h3 class="text-base lg:text-lg font-bold text-[#018B3E]">Bukti Pembayaran</h3>
                                <p class="text-xs text-slate-500">Upload bukti transfer / pembayaran pendaftaran</p>
                            </div>
                        </div>

                        {{-- Informasi Pembayaran --}}
                        <div class="mb-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-blue-600 text-base shrink-0 mt-0.5">payments</span>
                                <div class="text-xs lg:text-sm">
                                    <p class="font-semibold text-slate-800">Informasi Pembayaran</p>
                                    @if($periodeInfo['biaya'] > 0)
                                        <p class="text-slate-600 mt-1">Biaya pendaftaran: <span class="font-bold text-primary">Rp {{ number_format($periodeInfo['biaya'], 0, ',', '.') }}</span></p>
                                        <p class="text-slate-600 mt-1">Transfer ke rekening: <br>
                                            <span class="font-semibold">Bank Syariah Indonesia (BSI) - 1234567890 a.n. SMK NU II Medan</span>
                                        </p>
                                    @else
                                        <p class="text-slate-600 mt-1">Biaya pendaftaran: <span class="font-bold text-green-600">GRATIS</span></p>
                                        <p class="text-slate-600 mt-1">Anda tetap perlu mengupload bukti pembayaran sebagai tanda registrasi.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Upload Bukti Pembayaran --}}
                        @php $buktiBayar = $dokumen['bukti_pembayaran'] ?? null; @endphp
                        <div class="p-4 lg:p-5 rounded-xl border-2 transition-all"
                             id="wrap-bukti_pembayaran"
                             style="border-color:{{ $buktiBayar ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $buktiBayar ? 'rgba(1,139,62,0.04)' : '#f8fafc' }};">
                            <div class="flex items-start gap-3 lg:gap-4">
                                <div class="size-10 lg:size-12 rounded-xl flex items-center justify-center shrink-0 text-white" style="background-color:#018B3E;">
                                    <span class="material-symbols-outlined text-xl lg:text-2xl">receipt</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm lg:text-base font-semibold text-slate-900">
                                        Bukti Pembayaran <span class="text-red-500">*</span>
                                    </p>
                                    <p class="text-[10px] lg:text-xs text-slate-500 mt-0.5">Upload bukti transfer / pembayaran (PDF/JPG/PNG, maks 2MB)</p>

                                    @if($buktiBayar)
                                        <div class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            <span class="truncate max-w-[150px] lg:max-w-[200px]">{{ $buktiBayar->nama_file }}</span>
                                        </div>
                                    @endif

                                    <label class="mt-2 lg:mt-3 flex items-center gap-2 lg:gap-3 cursor-pointer group" for="file-bukti_pembayaran">
                                        <div class="flex-1 px-3 lg:px-4 py-2 lg:py-2.5 rounded-lg border-2 border-dashed text-xs lg:text-sm text-slate-400 transition-all flex items-center gap-2"
                                             style="border-color:rgba(1,139,62,0.25);">
                                            <span class="material-symbols-outlined text-sm lg:text-base">upload_file</span>
                                            <span id="text-bukti_pembayaran" class="truncate max-w-[120px] lg:max-w-[200px]">
                                                {{ $buktiBayar ? 'Klik untuk ganti file' : 'Klik untuk pilih file' }}
                                            </span>
                                        </div>
                                        <input id="file-bukti_pembayaran" type="file"
                                               name="bukti_pembayaran" accept=".pdf,.jpg,.jpeg,.png"
                                               class="sr-only"
                                               {{ !$buktiBayar ? 'required' : '' }}
                                               onchange="handleFileSelect(this, 'bukti_pembayaran')">
                                    </label>

                                    @error('bukti_pembayaran')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if($buktiBayar)
                                    <span class="shrink-0 inline-flex items-center gap-1 text-[10px] lg:text-xs font-bold px-2 py-1 rounded-full"
                                          style="background-color:rgba(1,139,62,0.1); color:#018B3E;">
                                        <span class="material-symbols-outlined text-xs lg:text-sm">check_circle</span>
                                        <span class="hidden sm:inline">Terupload</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="p-3 lg:p-4 rounded-xl flex items-start gap-2 lg:gap-3 bg-yellow-50 border border-yellow-200">
                        <span class="material-symbols-outlined shrink-0 mt-0.5 text-amber-600 text-base lg:text-lg">info</span>
                        <div class="text-xs lg:text-sm">
                            <p class="font-semibold text-slate-800">Pastikan dokumen Anda valid</p>
                            <p class="text-slate-600 mt-0.5">File harus terbaca jelas, tidak buram, dan tidak terpotong. Format: PDF, JPG, atau PNG. Ukuran maksimal 2MB per file.</p>
                        </div>
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="pt-6 lg:pt-8 flex flex-col-reverse sm:flex-row gap-3 lg:gap-4" style="border-top: 1px solid #f1f5f9;">
                        <a href="{{ route('siswa.pendaftaran.step4') }}"
                            class="sm:flex-1 py-3 lg:py-4 px-4 lg:px-6 rounded-xl font-bold text-sm lg:text-base text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-lg">arrow_back</span>
                            Kembali
                        </a>
                        <button type="submit"
                                class="sm:flex-[2] py-3 lg:py-4 px-4 lg:px-6 rounded-xl font-bold text-sm lg:text-base text-white transition-all flex items-center justify-center gap-2"
                                style="background-color: #018B3E; box-shadow: 0 8px 24px rgba(1,139,62,0.25);"
                                onmouseover="this.style.backgroundColor='#016b30';"
                                onmouseout="this.style.backgroundColor='#018B3E';">
                            <span class="material-symbols-outlined text-lg">send</span>
                            <span class="hidden xs:inline">Kirim Pendaftaran</span>
                            <span class="inline xs:hidden">Kirim</span>
                        </button>
                    </div>
                </form>
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

function handleFileSelect(input, docName) {
    const file = input.files[0];
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar! Maksimal 2MB.');
        input.value = '';
        return;
    }
    const textEl = document.getElementById('text-' + docName);
    if (textEl) {
        textEl.textContent = file.name;
    }
    const wrap = document.getElementById('wrap-' + docName);
    if (wrap) {
        wrap.style.borderColor = '#018B3E';
        wrap.style.backgroundColor = 'rgba(1,139,62,0.04)';
    }
}

// Mobile menu button
document.getElementById('mobile-menu-button')?.addEventListener('click', toggleMobileSidebar);

// Close sidebar when clicking outside
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('mobile-sidebar');
    const menuButton = document.getElementById('mobile-menu-button');
    if (sidebar && !sidebar.classList.contains('hidden')) {
        if (!sidebar.contains(e.target) && !menuButton?.contains(e.target)) {
            sidebar.classList.add('hidden');
        }
    }
});
</script>
@endsection