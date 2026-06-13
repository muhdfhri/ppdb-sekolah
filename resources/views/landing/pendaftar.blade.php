@extends('layouts.app')

@section('title', 'Pendaftaran Siswa Baru - SMK NU II Medan')

@section('content')
    @include('partials.navbar')

    <div class="py-12 bg-background-light min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Stepper Progress --}}
            <div x-data="{ 
                                    step: @if($errors->hasAny(['nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'alamat_lengkap', 'no_telepon', 'email', 'nama_sekolah', 'alamat_sekolah', 'tahun_lulus', 'nisn', 'nilai_rata_rata', 'nama_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'telp_ayah', 'nama_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu', 'pekerjaan_ibu'])) 1 
                                      @elseif($errors->hasAny(['jurusan_id', 'jurusan_id_2'])) 2 
                                      @elseif($errors->hasAny(['ijazah', 'kartu_keluarga', 'akte_kelahiran', 'pas_foto', 'bukti_pembayaran', 'kip'])) 3 
                                      @else 1 @endif
                                }" class="space-y-8">

                {{-- Header Title --}}
                <div class="text-center">
                    <span
                        class="text-brand-primary font-bold text-xs uppercase tracking-widest bg-brand-primary/10 px-3.5 py-1.5 rounded-full">Formulir
                        PPDB Online</span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3">Pendaftaran Siswa Baru</h1>
                    <p class="text-sm text-slate-500 mt-1.5">Tahun Pelajaran {{ $periode->tahun_ajaran ?? '2026/2027' }}</p>
                </div>

                {{-- Alert Global Errors --}}
                @if($errors->any())
                    <div class="flex items-start gap-3 p-4 rounded-xl text-sm bg-error/10 border border-error/20 text-error">
                        <span class="material-symbols-outlined shrink-0 mt-0.5 text-base">error</span>
                        <div class="flex-1">
                            <span class="font-bold block mb-1">Ada kesalahan pengisian form:</span>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Stepper Indicator --}}
                <div class="relative flex justify-between items-center max-w-lg mx-auto mb-12">
                    {{-- Progress Line --}}
                    <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-0.5 bg-base-300 -z-10"></div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-brand-primary transition-all duration-300 -z-10"
                        :style="'width: ' + ((step - 1) * 50) + '%'"></div>

                    {{-- Step 1 --}}
                    <div class="flex flex-col items-center">
                        <button type="button" @click="if(step > 1) step = 1"
                            class="size-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                            :class="step >= 1 ? 'bg-brand-primary text-white ring-4 ring-brand-primary/20' : 'bg-base-300 text-slate-500'">
                            1
                        </button>
                        <span class="text-xs font-bold mt-2"
                            :class="step >= 1 ? 'text-brand-primary' : 'text-slate-400'">Biodata</span>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex flex-col items-center">
                        <button type="button" @click="if(step > 2) step = 2"
                            class="size-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                            :class="step >= 2 ? 'bg-brand-primary text-white ring-4 ring-brand-primary/20' : 'bg-base-300 text-slate-500'">
                            2
                        </button>
                        <span class="text-xs font-bold mt-2"
                            :class="step >= 2 ? 'text-brand-primary' : 'text-slate-400'">Akademik</span>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex flex-col items-center">
                        <button type="button" disabled
                            class="size-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                            :class="step >= 3 ? 'bg-brand-primary text-white ring-4 ring-brand-primary/20' : 'bg-base-300 text-slate-500'">
                            3
                        </button>
                        <span class="text-xs font-bold mt-2"
                            :class="step >= 3 ? 'text-brand-primary' : 'text-slate-400'">Berkas</span>
                    </div>
                </div>

                {{-- FORM START --}}
                <form action="{{ route('landing.pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    {{-- ========================================== --}}
                    {{-- STEP 1: BIODATA PENDAFTAR --}}
                    {{-- ========================================== --}}
                    <div x-show="step === 1" class="space-y-6" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">

                        {{-- Card A: Data Pribadi --}}
                        <div class="bg-base-100 rounded-2xl p-6 sm:p-8 shadow-sm border border-base-300 space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-base-200">
                                <span class="material-symbols-outlined text-brand-primary text-2xl">person</span>
                                <h3 class="text-lg font-bold text-slate-900">A. Data Pribadi Calon Siswa</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Nama Lengkap --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span
                                            class="text-error">*</span></label>
                                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                        placeholder="Sesuai Akta Kelahiran / Ijazah">
                                </div>

                                {{-- NIK --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIK <span
                                            class="text-error">*</span></label>
                                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                        placeholder="16 Digit NIK">
                                    <p class="text-[11px] text-slate-400 mt-1">* Harus 16 digit angka</p>
                                </div>

                                {{-- Tempat Lahir --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir <span
                                            class="text-error">*</span></label>
                                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                        placeholder="Contoh: Medan">
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span
                                            class="text-error">*</span></label>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base">
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span
                                            class="text-error">*</span></label>
                                    <select name="jenis_kelamin" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2364748b%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>

                                {{-- Agama --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Agama <span
                                            class="text-error">*</span></label>
                                    <select name="agama" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2364748b%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat">
                                        <option value="">Pilih Agama</option>
                                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                            <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>
                                                {{ $agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- No Telepon --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon / WhatsApp
                                        <span class="text-error">*</span></label>
                                    <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                        placeholder="Contoh: 081234567890">
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email <span
                                            class="text-error">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                        placeholder="Contoh: siswa@gmail.com">
                                </div>

                                {{-- Alamat Lengkap --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap <span
                                            class="text-error">*</span></label>
                                    <textarea name="alamat_lengkap" rows="3" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base resize-none"
                                        placeholder="Nama Jalan, Blok, RT/RW, Kelurahan, Kecamatan, Kabupaten/Kota">{{ old('alamat_lengkap') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Card B: Sekolah Asal --}}
                        <div class="bg-base-100 rounded-2xl p-6 sm:p-8 shadow-sm border border-base-300 space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-base-200">
                                <span class="material-symbols-outlined text-brand-primary text-2xl">school</span>
                                <h3 class="text-lg font-bold text-slate-900">B. Data Sekolah Asal</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Nama Sekolah --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Sekolah Asal <span
                                            class="text-error">*</span></label>
                                    <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                        placeholder="Contoh: SMP Negeri 1 Medan">
                                </div>

                                {{-- NISN --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">NISN <span
                                            class="text-error">*</span></label>
                                    <input type="text" name="nisn" value="{{ old('nisn') }}" maxlength="20" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                        placeholder="Masukkan NISN">
                                </div>

                                {{-- Tahun Lulus --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Lulus <span
                                            class="text-error">*</span></label>
                                    <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', date('Y')) }}"
                                        required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base">
                                </div>

                                {{-- Nilai Rata-rata Rapor --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nilai Rata-rata Rapor /
                                        Ijazah <span class="text-error">*</span></label>
                                    <input type="number" step="0.01" name="nilai_rata_rata"
                                        value="{{ old('nilai_rata_rata') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                        placeholder="Contoh: 85.50">
                                </div>

                                {{-- Alamat Sekolah --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Sekolah Asal <span
                                            class="text-error">*</span></label>
                                    <textarea name="alamat_sekolah" rows="2" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base resize-none"
                                        placeholder="Masukkan kota/kecamatan alamat sekolah asal">{{ old('alamat_sekolah') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Card C: Data Orang Tua --}}
                        <div class="bg-base-100 rounded-2xl p-6 sm:p-8 shadow-sm border border-base-300 space-y-8">
                            <div class="flex items-center gap-3 pb-4 border-b border-base-200">
                                <span class="material-symbols-outlined text-brand-primary text-2xl">family_restroom</span>
                                <h3 class="text-lg font-bold text-slate-900">C. Data Orang Tua Calon Siswa</h3>
                            </div>

                            {{-- Sub-Card C1: Data Ayah --}}
                            <div class="space-y-5">
                                <h4 class="text-sm font-bold uppercase tracking-wider text-brand-primary">1. Data Ayah
                                    Kandung</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="col-span-1 md:col-span-2">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Ayah
                                            <span class="text-error">*</span></label>
                                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="Nama lengkap sesuai KK/KTP">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">NIK Ayah <span
                                                class="text-error">*</span></label>
                                        <input type="text" name="nik_ayah" value="{{ old('nik_ayah') }}" maxlength="16"
                                            required oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="16 Digit NIK Ayah">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP / WhatsApp
                                            Ayah <span class="text-error">*</span></label>
                                        <input type="tel" name="telp_ayah" value="{{ old('telp_ayah') }}" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="Contoh: 081234567890">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir Ayah
                                            <span class="text-error">*</span></label>
                                        <input type="text" name="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="Tempat Lahir Ayah">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir Ayah
                                            <span class="text-error">*</span></label>
                                        <input type="date" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan Ayah <span
                                                class="text-error">*</span></label>
                                        <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="Contoh: Wiraswasta, Karyawan Swasta, PNS">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Penghasilan Bulanan
                                            Ayah <span class="text-error">*</span></label>
                                        <select name="penghasilan_ayah" required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2364748b%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat">
                                            <option value="">Pilih Penghasilan</option>
                                            <option value="kurang_1jt" {{ old('penghasilan_ayah') == 'kurang_1jt' ? 'selected' : '' }}>Kurang dari Rp 1.000.000</option>
                                            <option value="1jt_3jt" {{ old('penghasilan_ayah') == '1jt_3jt' ? 'selected' : '' }}>Rp 1.000.000 - Rp 3.000.000</option>
                                            <option value="3jt_5jt" {{ old('penghasilan_ayah') == '3jt_5jt' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                            <option value="5jt_10jt" {{ old('penghasilan_ayah') == '5jt_10jt' ? 'selected' : '' }}>Rp 5.000.000 - Rp 10.000.000</option>
                                            <option value="lebih_10jt" {{ old('penghasilan_ayah') == 'lebih_10jt' ? 'selected' : '' }}>Lebih dari Rp 10.000.000</option>
                                        </select>
                                    </div>

                                    <div class="col-span-1 md:col-span-2">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Ayah <span
                                                class="text-error">*</span></label>
                                        <textarea name="alamat_ayah" rows="2" required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base resize-none"
                                            placeholder="Alamat lengkap ayah kandung">{{ old('alamat_ayah') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-base-200">

                            {{-- Sub-Card C2: Data Ibu --}}
                            <div class="space-y-5">
                                <h4 class="text-sm font-bold uppercase tracking-wider text-brand-primary">2. Data Ibu
                                    Kandung</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="col-span-1 md:col-span-2">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Ibu
                                            <span class="text-error">*</span></label>
                                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="Nama lengkap sesuai KK/KTP">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">NIK Ibu <span
                                                class="text-error">*</span></label>
                                        <input type="text" name="nik_ibu" value="{{ old('nik_ibu') }}" maxlength="16"
                                            required oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="16 Digit NIK Ibu">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP / WhatsApp Ibu
                                            <span class="text-error">*</span></label>
                                        <input type="tel" name="telp_ibu" value="{{ old('telp_ibu') }}" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="Contoh: 081234567890">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir Ibu
                                            <span class="text-error">*</span></label>
                                        <input type="text" name="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="Tempat Lahir Ibu">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir Ibu
                                            <span class="text-error">*</span></label>
                                        <input type="date" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base">
                                    </div>

                                    <div class="col-span-1 md:col-span-2">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan Ibu <span
                                                class="text-error">*</span></label>
                                        <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base"
                                            placeholder="Contoh: Ibu Rumah Tangga, Wiraswasta, Guru">
                                    </div>

                                    <div class="col-span-1 md:col-span-2">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Ibu <span
                                                class="text-error">*</span></label>
                                        <textarea name="alamat_ibu" rows="2" required
                                            class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base resize-none"
                                            placeholder="Alamat lengkap ibu kandung">{{ old('alamat_ibu') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Nav Button Step 1 --}}
                        <div class="pt-6 flex justify-end">
                            <button type="button" @click="if(window.validateStep(1)) step = 2"
                                class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-white transition-all flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-primary/95 shadow-md shadow-brand-primary/20">
                                Lanjut ke Akademik <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    {{-- ========================================== --}}
                    {{-- STEP 2: INFORMASI AKADEMIK --}}
                    {{-- ========================================== --}}
                    <div x-show="step === 2" class="space-y-6" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">

                        <div class="bg-base-100 rounded-2xl p-6 sm:p-8 shadow-sm border border-base-300 space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-base-200">
                                <span class="material-symbols-outlined text-brand-primary text-2xl">school</span>
                                <h3 class="text-lg font-bold text-slate-900">Pilihan Jurusan</h3>
                            </div>

                            <p class="text-sm text-slate-500">Silakan tentukan prioritas jurusan/program keahlian yang ingin
                                Anda masuki.</p>

                            <div class="space-y-5">
                                {{-- Pilihan 1 --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jurusan Pilihan Utama
                                        <span class="text-error">*</span></label>
                                    <select name="jurusan_id" required
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2364748b%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat">
                                        <option value="">Pilih Jurusan Pertama</option>
                                        @foreach($jurusan as $j)
                                            <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                                {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Pilihan 2 --}}
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jurusan Pilihan Kedua
                                        (Cadangan)</label>
                                    <select name="jurusan_id_2"
                                        class="w-full px-4 py-3 rounded-xl border border-base-300 bg-base-200/30 text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm sm:text-base appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2364748b%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat">
                                        <option value="">Pilih Jurusan Kedua</option>
                                        @foreach($jurusan as $j)
                                            <option value="{{ $j->id }}" {{ old('jurusan_id_2') == $j->id ? 'selected' : '' }}>
                                                {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Nav Buttons Step 2 --}}
                        <div class="pt-6 flex flex-col-reverse sm:flex-row gap-3">
                            <button type="button" @click="step = 1"
                                class="sm:flex-1 py-3 px-6 rounded-xl font-bold text-slate-600 bg-base-300/60 hover:bg-base-300 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                            </button>
                            <button type="button" @click="if(window.validateStep(2)) step = 3"
                                class="sm:flex-[2] py-3.5 px-6 rounded-xl font-bold text-white transition-all flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-primary/95 shadow-md shadow-brand-primary/20">
                                Lanjut ke Berkas <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    {{-- ========================================== --}}
                    {{-- STEP 3: VERIFIKASI BERKAS --}}
                    {{-- ========================================== --}}
                    <div x-show="step === 3" class="space-y-6" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">

                        <div class="bg-base-100 rounded-2xl p-6 sm:p-8 shadow-sm border border-base-300 space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-base-200">
                                <span class="material-symbols-outlined text-brand-primary text-2xl">folder_zip</span>
                                <h3 class="text-lg font-bold text-slate-900">Upload Dokumen Persyaratan</h3>
                            </div>

                            <p class="text-sm text-slate-500">Silakan unggah pindaian dokumen berikut dalam format gambar
                                (JPG/PNG) atau PDF (maksimal 2MB per file).</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Ijazah --}}
                                <div class="p-4 bg-base-200/40 rounded-xl border border-base-300">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Ijazah / SKL (Surat
                                        Keterangan Lulus) <span class="text-error">*</span></label>
                                    <input type="file" name="ijazah" required
                                        accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20">
                                </div>

                                {{-- Kartu Keluarga --}}
                                <div class="p-4 bg-base-200/40 rounded-xl border border-base-300">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Kartu Keluarga <span
                                            class="text-error">*</span></label>
                                    <input type="file" name="kartu_keluarga" required
                                        accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20">
                                </div>

                                {{-- Akte Kelahiran --}}
                                <div class="p-4 bg-base-200/40 rounded-xl border border-base-300">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Akta Kelahiran <span
                                            class="text-error">*</span></label>
                                    <input type="file" name="akte_kelahiran" required
                                        accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20">
                                </div>

                                {{-- Pas Foto --}}
                                <div class="p-4 bg-base-200/40 rounded-xl border border-base-300">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Pas Foto 3x4 <span
                                            class="text-error">*</span></label>
                                    <input type="file" name="pas_foto" required accept="image/png,image/jpeg,image/jpg"
                                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20">
                                </div>

                                {{-- Bukti Pembayaran --}}
                                <div class="p-4 bg-base-200/40 rounded-xl border border-base-300">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Bukti Pembayaran Pendaftaran
                                        <span class="text-error">*</span></label>
                                    <input type="file" name="bukti_pembayaran" required
                                        accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20">
                                </div>

                                {{-- KIP --}}
                                <div class="p-4 bg-base-200/40 rounded-xl border border-base-300">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Kartu Indonesia Pintar (KIP)
                                        - Opsional</label>
                                    <input type="file" name="kip" accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20">
                                </div>
                            </div>
                        </div>

                        {{-- Finalisasi Confirmation --}}
                        <div class="bg-base-100 rounded-2xl p-6 sm:p-8 shadow-sm border border-base-300 space-y-4">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" required class="checkbox checkbox-primary mt-0.5 rounded-md">
                                <span class="text-xs sm:text-sm text-slate-600 font-medium">Saya menyatakan bahwa seluruh
                                    data yang diisi dan berkas yang diupload adalah benar, sah, dan sesuai dengan berkas
                                    asli. Saya bertanggung jawab penuh atas kebenaran data ini.</span>
                            </label>
                        </div>

                        {{-- Nav Buttons Step 3 --}}
                        <div class="pt-6 flex flex-col-reverse sm:flex-row gap-3">
                            <button type="button" @click="step = 2"
                                class="sm:flex-1 py-3 px-6 rounded-xl font-bold text-slate-600 bg-base-300/60 hover:bg-base-300 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                            </button>
                            <button type="submit"
                                class="sm:flex-[2] py-3.5 px-6 rounded-xl font-bold text-white transition-all flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-primary/95 shadow-md shadow-brand-primary/20">
                                <span class="material-symbols-outlined text-lg">send</span> Kirim Pendaftaran
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.footer')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const fileInputs = form.querySelectorAll('input[type="file"]');
            const maxFileSize = 2 * 1024 * 1024; // 2MB
            const maxTotalSize = 10 * 1024 * 1024; // 10MB

            fileInputs.forEach(input => {
                const errorEl = document.createElement('p');
                errorEl.className = 'text-xs text-red-500 mt-1.5 hidden';
                input.parentNode.appendChild(errorEl);

                input.addEventListener('change', function () {
                    errorEl.classList.add('hidden');
                    errorEl.textContent = '';
                    const container = input.parentNode;

                    if (this.files && this.files.length > 0) {
                        const file = this.files[0];

                        if (file.size > maxFileSize) {
                            errorEl.textContent = 'Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.';
                            errorEl.classList.remove('hidden');
                            container.classList.remove('border-base-300');
                            container.classList.add('border-red-500', 'ring-2', 'ring-red-500/20');
                            this.value = '';
                            return;
                        }

                        const allowedExtensions = input.name === 'pas_foto' ? ['.png', '.jpg', '.jpeg'] : ['.pdf', '.png', '.jpg', '.jpeg'];
                        const fileExt = '.' + file.name.split('.').pop().toLowerCase();
                        if (!allowedExtensions.includes(fileExt)) {
                            errorEl.textContent = 'Format berkas tidak didukung (' + (input.name === 'pas_foto' ? 'JPG/PNG' : 'PDF/JPG/PNG') + ').';
                            errorEl.classList.remove('hidden');
                            container.classList.remove('border-base-300');
                            container.classList.add('border-red-500', 'ring-2', 'ring-red-500/20');
                            this.value = '';
                            return;
                        }

                        container.classList.remove('border-red-500', 'ring-2', 'ring-red-500/20');
                        container.classList.add('border-base-300');
                    }
                });
            });

            // Client-side step validation
            window.validateStep = function (stepNumber) {
                const container = document.querySelector(`[x-show="step === ${stepNumber}"]`);
                if (!container) return true;

                const inputs = container.querySelectorAll('input, select, textarea');
                let isValid = true;

                container.querySelectorAll('.client-error-msg').forEach(el => el.remove());

                inputs.forEach(input => {
                    if (input.disabled) return;

                    let isFieldValid = true;
                    let errorMessage = '';
                    const val = input.value.trim();

                    if (input.required) {
                        if (input.type === 'checkbox' && !input.checked) {
                            isFieldValid = false;
                            errorMessage = 'Pernyataan ini wajib disetujui.';
                        } else if (input.type === 'file' && (!input.files || input.files.length === 0)) {
                            isFieldValid = false;
                            errorMessage = 'Berkas dokumen wajib diunggah.';
                        } else if (val === '' && input.type !== 'checkbox' && input.type !== 'file') {
                            isFieldValid = false;
                            errorMessage = 'Kolom ini wajib diisi.';
                        }
                    }

                    if (isFieldValid && val !== '') {
                        if (['nik', 'nik_ayah', 'nik_ibu'].includes(input.name) && !/^\d{16}$/.test(val)) {
                            isFieldValid = false;
                            errorMessage = 'NIK harus berupa 16 digit angka.';
                        } else if (['no_telepon', 'telp_ayah', 'telp_ibu'].includes(input.name) && !/^\d{9,15}$/.test(val)) {
                            isFieldValid = false;
                            errorMessage = 'Nomor telepon tidak valid (9-15 digit angka).';
                        } else if (input.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
                            isFieldValid = false;
                            errorMessage = 'Format email tidak valid.';
                        } else if (input.name === 'nisn' && !/^\d{8,20}$/.test(val)) {
                            isFieldValid = false;
                            errorMessage = 'NISN tidak valid (8-20 digit angka).';
                        } else if (input.name === 'nilai_rata_rata') {
                            const score = parseFloat(val);
                            if (isNaN(score) || score < 0 || score > 100) {
                                isFieldValid = false;
                                errorMessage = 'Nilai harus di antara 0 - 100.';
                            }
                        }
                    }

                    if (!isFieldValid) {
                        isValid = false;
                        const targetElement = input.type === 'file' ? input.parentNode : input;
                        targetElement.classList.remove('border-base-300');
                        targetElement.classList.add('border-red-500', 'ring-2', 'ring-red-500/20');

                        const errorEl = document.createElement('p');
                        errorEl.className = 'text-xs text-red-500 mt-1 client-error-msg';
                        errorEl.textContent = errorMessage;
                        input.parentNode.appendChild(errorEl);

                        const clearError = () => {
                            targetElement.classList.remove('border-red-500', 'ring-2', 'ring-red-500/20');
                            targetElement.classList.add('border-base-300');
                            errorEl.remove();
                        };
                        input.addEventListener('input', clearError, { once: true });
                        input.addEventListener('change', clearError, { once: true });
                    }
                });

                if (!isValid) {
                    window.showToast('Ada kolom yang belum diisi atau formatnya salah. Silakan periksa kembali.', 'error');
                }

                return isValid;
            };

            form.addEventListener('submit', function (e) {
                if (!window.validateStep(1) || !window.validateStep(2) || !window.validateStep(3)) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endpush