@extends('layouts.siswa')

@section('title', 'Langkah 2 - Sekolah Asal | PPDB SMK NU II Medan')
@section('breadcrumb_parent', 'Pendaftaran')
@section('breadcrumb', 'Langkah 2: Sekolah Asal')

@section('content')
    <div class="space-y-6 lg:space-y-8 max-w-7xl w-full">

        @include('siswa.partials.stepper', ['currentStep' => 2])

        @if($errors->any())
            <div class="flex items-start gap-3 p-4 rounded-xl text-sm bg-red-50 border border-red-200 text-red-600">
                <span class="material-symbols-outlined shrink-0 mt-0.5 text-base">error</span>
                <ul class="flex-1 list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
        @endif

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
                            <input type="text" name="nisn" value="{{ old('nisn', $sekolah->nisn ?? '') }}" maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all @error('nisn') border-red-500 @enderror"
                                style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                placeholder="10 digit NISN" inputmode="numeric" pattern="[0-9]{10}"
                                title="NISN harus 10 digit angka">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">* NISN terdiri dari 10 digit angka</p>
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
                                class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all @error('nama_sekolah') border-red-500 @enderror"
                                style="border:1px solid #e2e8f0; background-color:#f8fafc;"
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
                                class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all resize-none @error('alamat_sekolah') border-red-500 @enderror"
                                style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                placeholder="Alamat lengkap sekolah asal">{{ old('alamat_sekolah', $sekolah->alamat_sekolah ?? '') }}</textarea>
                        </div>
                        @error('alamat_sekolah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tahun Lulus --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Lulus <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">calendar_today</span>
                            <input type="text" name="tahun_lulus"
                                value="{{ old('tahun_lulus', $sekolah->tahun_lulus ?? '') }}" required min="2000"
                                max="{{ date('Y') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all @error('tahun_lulus') border-red-500 @enderror"
                                style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                placeholder="Contoh: 2024" inputmode="numeric" pattern="[0-9]{4}"
                                title="Tahun lulus harus 4 digit angka">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">* Format tahun: 4 digit angka (contoh: 2024)</p>
                        @error('tahun_lulus') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nilai Rata-rata --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nilai Rata-rata Rapor</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">grade</span>
                            <input type="text" name="nilai_rata_rata"
                                value="{{ old('nilai_rata_rata', $sekolah->nilai_rata_rata ?? '') }}" step="0.01" min="0"
                                max="100"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all @error('nilai_rata_rata') border-red-500 @enderror"
                                style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                placeholder="Contoh: 85.50" inputmode="decimal" pattern="[0-9]+(\.[0-9]{1,2})?"
                                title="Nilai rata-rata harus berupa angka (contoh: 85.50)">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">* Nilai 0-100, boleh menggunakan desimal (contoh: 85.50)</p>
                        @error('nilai_rata_rata') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-6 lg:pt-8 flex flex-col-reverse sm:flex-row gap-3 lg:gap-4"
                    style="border-top:1px solid #f1f5f9;">
                    <a href="{{ route('siswa.pendaftaran.step1') }}"
                        class="sm:flex-1 py-3 lg:py-4 px-6 rounded-xl font-bold text-sm lg:text-base text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                    </a>
                    <button type="submit"
                        class="sm:flex-[2] py-3 lg:py-4 px-6 rounded-xl font-bold text-sm lg:text-base text-white transition-all flex items-center justify-center gap-2"
                        style="background-color:#018B3E; box-shadow:0 8px 24px rgba(1,139,62,0.25);"
                        onmouseover="this.style.backgroundColor='#016b30';"
                        onmouseout="this.style.backgroundColor='#018B3E';">
                        Lanjut ke Tahap Berikutnya <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection