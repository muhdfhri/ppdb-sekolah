{{-- resources/views/siswa/pendaftaran/step1.blade.php --}}
@extends('layouts.app')

@section('title', 'Langkah 1 - Data Pribadi | PPDB SMK NU II Medan')

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
                <span class="font-semibold text-[#018B3E]">Langkah 1: Data Pribadi</span>
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
            {{-- Stepper (sudah responsive) --}}
            @include('siswa.partials.stepper', ['currentStep' => 1])

            {{-- Alerts --}}
            @if(session('success'))
                <div class="flex items-start gap-3 p-4 rounded-xl text-sm font-medium bg-green-50 border border-green-200 text-green-700">
                    <span class="material-symbols-outlined shrink-0 mt-0.5 text-base">check_circle</span>
                    <span class="flex-1">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="flex items-start gap-3 p-4 rounded-xl text-sm bg-red-50 border border-red-200 text-red-600">
                    <span class="material-symbols-outlined shrink-0 mt-0.5 text-base">error</span>
                    <ul class="flex-1 list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 shadow-sm border border-slate-200">
                <div class="mb-6 lg:mb-8">
                    <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Registrasi Siswa Baru</h2>
                    <p class="text-sm lg:text-base text-slate-500 mt-1">Langkah 1: Silakan lengkapi data pribadi Anda dengan benar sesuai dokumen resmi.</p>
                </div>

                <form action="{{ route('siswa.pendaftaran.step1.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                        {{-- NIK --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">NIK <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">fingerprint</span>
                                <input type="text" name="nik" value="{{ old('nik', $siswa->nik ?? '') }}"
                                       maxlength="16" required
                                       class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                       style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                       onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                       placeholder="Masukkan 16 digit NIK">
                            </div>
                            @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap ?? '') }}" required
                                       class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                       style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                       onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                       placeholder="Sesuai Akta Kelahiran / Ijazah">
                            </div>
                            @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tempat Lahir & Tanggal Lahir --}}
                        <div class="col-span-1">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">location_on</span>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}" required
                                       class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                       style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                       onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                       placeholder="Contoh: Medan">
                            </div>
                            @error('tempat_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">calendar_today</span>
                                <input type="date" name="tanggal_lahir"
                                       value="{{ old('tanggal_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}"
                                       required
                                       class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                       style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                       onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                            </div>
                            @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-3 lg:gap-4">
                                @php $jk = old('jenis_kelamin', $siswa->jenis_kelamin ?? ''); @endphp
                                <label class="gender-label flex items-center justify-center gap-1 lg:gap-2 p-3 lg:p-4 rounded-xl border-2 cursor-pointer transition-all text-sm lg:text-base"
                                    style="border-color: {{ $jk == 'Laki-laki' ? '#018B3E' : '#f1f5f9' }}; background-color: {{ $jk == 'Laki-laki' ? 'rgba(1,139,62,0.05)' : '#f8fafc' }};">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" class="sr-only"
                                           {{ $jk == 'Laki-laki' ? 'checked' : '' }}
                                           onchange="updateGender(this)">
                                    <span class="material-symbols-outlined text-lg lg:text-xl text-[#018B3E]">male</span>
                                    <span class="font-medium text-slate-700">Laki-laki</span>
                                </label>
                                <label class="gender-label flex items-center justify-center gap-1 lg:gap-2 p-3 lg:p-4 rounded-xl border-2 cursor-pointer transition-all text-sm lg:text-base"
                                    style="border-color: {{ $jk == 'Perempuan' ? '#018B3E' : '#f1f5f9' }}; background-color: {{ $jk == 'Perempuan' ? 'rgba(1,139,62,0.05)' : '#f8fafc' }};">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" class="sr-only"
                                           {{ $jk == 'Perempuan' ? 'checked' : '' }}
                                           onchange="updateGender(this)">
                                    <span class="material-symbols-outlined text-lg lg:text-xl text-[#018B3E]">female</span>
                                    <span class="font-medium text-slate-700">Perempuan</span>
                                </label>
                            </div>
                            @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Agama --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Agama <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">church</span>
                                <select name="agama" required
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all appearance-none"
                                        style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                    <option value="">Pilih Agama</option>
                                    @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                        <option value="{{ $agama }}" {{ old('agama', $siswa->agama ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('agama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- No Telepon --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">call</span>
                                <input type="tel" name="no_telepon" value="{{ old('no_telepon', $siswa->no_telepon ?? '') }}"
                                       class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                       style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                       onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                       placeholder="Contoh: 081234567890">
                            </div>
                            @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                                <input type="email" name="email" value="{{ old('email', $siswa->email ?? '') }}"
                                       class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all"
                                       style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                       onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                       placeholder="contoh@email.com">
                            </div>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Alamat Lengkap --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 lg:left-4 top-4 text-slate-400 text-xl">home</span>
                                <textarea name="alamat_lengkap" required rows="3"
                                          class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl border border-slate-200 bg-slate-50 outline-none transition-all resize-none"
                                          style="border: 1px solid #e2e8f0; background-color: #f8fafc;"
                                          onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                          onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                          placeholder="Nama Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan">{{ old('alamat_lengkap', $siswa->alamat_lengkap ?? '') }}</textarea>
                            </div>
                            @error('alamat_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Navigation Buttons (stack di mobile, row di desktop) --}}
                    <div class="pt-6 lg:pt-8 flex flex-col-reverse sm:flex-row gap-3 lg:gap-4" style="border-top: 1px solid #f1f5f9;">
                        <a href="{{ route('siswa.pendaftaran.index') }}"
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

function updateGender(input) {
    document.querySelectorAll('.gender-label').forEach(label => {
        const radio = label.querySelector('input[type="radio"]');
        if (radio.checked) {
            label.style.borderColor = '#018B3E';
            label.style.backgroundColor = 'rgba(1,139,62,0.05)';
        } else {
            label.style.borderColor = '#f1f5f9';
            label.style.backgroundColor = '#f8fafc';
        }
    });
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

// Set initial gender state
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.gender-label input:checked').forEach(radio => {
        radio.closest('.gender-label').style.borderColor = '#018B3E';
        radio.closest('.gender-label').style.backgroundColor = 'rgba(1,139,62,0.05)';
    });
});
</script>
@endsection