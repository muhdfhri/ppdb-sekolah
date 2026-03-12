{{-- resources/views/siswa/pendaftaran/step2.blade.php --}}
@extends('layouts.app')

@section('title', 'Langkah 2 - Sekolah Asal | PPDB SMK NU II Medan')

@section('content')
    <div class="min-h-screen bg-[#F6F4F7] font-['Public Sans']">

        {{-- ================================================================
        MOBILE HEADER (hanya muncul di layar kecil)
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
        MOBILE SIDEBAR (hidden by default)
        ================================================================ --}}
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
                <button
                    class="w-full bg-[#F6CB04] text-[#0f2318] font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 transition-all hover:brightness-95 mt-4">
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
                        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
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
            <button
                class="w-full bg-[#F6CB04] text-[#0f2318] font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 transition-all hover:brightness-95">
                <span class="material-symbols-outlined">print</span>
                <span>Cetak Bukti</span>
            </button>
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
                    <span class="font-semibold text-[#018B3E]">Langkah 2: Sekolah Asal</span>
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

                {{-- Stepper --}}
                @include('siswa.partials.stepper', ['currentStep' => 2])

                {{-- Alerts --}}
                @if(session('success'))
                    <div
                        class="flex items-start gap-3 p-4 rounded-xl text-sm font-medium bg-green-50 border border-green-200 text-green-700">
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
                        <p class="text-sm lg:text-base text-slate-500 mt-1">Langkah 2: Isi informasi sekolah asal Anda.</p>
                    </div>

                    <form action="{{ route('siswa.pendaftaran.step2.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">

                            {{-- NISN --}}
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">NISN</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">badge</span>
                                    <input type="text" name="nisn" value="{{ old('nisn', $sekolah->nisn ?? '') }}"
                                        maxlength="10"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                        style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="10 digit NISN">
                                </div>
                                @error('nisn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Nama Sekolah --}}
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Sekolah Asal <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">school</span>
                                    <input type="text" name="nama_sekolah"
                                        value="{{ old('nama_sekolah', $sekolah->nama_sekolah ?? '') }}" required
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                        style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="Contoh: SMP Negeri 1 Medan">
                                </div>
                                @error('nama_sekolah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Alamat Sekolah --}}
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Sekolah</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-4 text-slate-400 text-xl">location_on</span>
                                    <textarea name="alamat_sekolah" rows="3"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all resize-none"
                                        style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="Alamat lengkap sekolah asal">{{ old('alamat_sekolah', $sekolah->alamat_sekolah ?? '') }}</textarea>
                                </div>
                            </div>

                            {{-- Tahun Lulus --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Lulus <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">calendar_today</span>
                                    <input type="number" name="tahun_lulus"
                                        value="{{ old('tahun_lulus', $sekolah->tahun_lulus ?? '') }}" required min="2000"
                                        max="{{ date('Y') }}"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                        style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="Contoh: 2024">
                                </div>
                                @error('tahun_lulus') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Nilai Rata-rata --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nilai Rata-rata Rapor</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">grade</span>
                                    <input type="number" name="nilai_rata_rata"
                                        value="{{ old('nilai_rata_rata', $sekolah->nilai_rata_rata ?? '') }}" step="0.01"
                                        min="0" max="100"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                        style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="Contoh: 85.50">
                                </div>
                                @error('nilai_rata_rata') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Navigation Buttons --}}
                        <div class="pt-6 lg:pt-8 flex flex-col-reverse sm:flex-row gap-3 lg:gap-4"
                            style="border-top: 1px solid #f1f5f9;">
                            <a href="{{ route('siswa.pendaftaran.step1') }}"
                                class="sm:flex-1 py-3 lg:py-4 px-4 lg:px-6 rounded-xl font-bold text-sm lg:text-base text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-lg">arrow_back</span>
                                Kembali
                            </a>
                            <button type="submit"
                                class="sm:flex-[2] py-3 lg:py-4 px-4 lg:px-6 rounded-xl font-bold text-sm lg:text-base text-white transition-all flex items-center justify-center gap-2"
                                style="background-color: #018B3E; box-shadow: 0 8px 24px rgba(1,139,62,0.25);"
                                onmouseover="this.style.backgroundColor='#016b30';"
                                onmouseout="this.style.backgroundColor='#018B3E';">
                                Lanjut ke Tahap Berikutnya
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
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
    </script>
@endsection