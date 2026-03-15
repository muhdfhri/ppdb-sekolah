@extends('layouts.siswa')

@section('title', 'Langkah 3 - Orang Tua | PPDB SMK NU II Medan')
@section('breadcrumb_parent', 'Pendaftaran')
@section('breadcrumb', 'Langkah 3: Data Orang Tua')

@section('content')
    <div class="space-y-6 lg:space-y-8 max-w-7xl w-full">

        @include('siswa.partials.stepper', ['currentStep' => 3])

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
                <p class="text-sm lg:text-base text-slate-500 mt-1">Langkah 3: Isi data orang tua / wali siswa.</p>
            </div>

            <form action="{{ route('siswa.pendaftaran.step3.store') }}" method="POST" class="space-y-6 lg:space-y-8">
                @csrf

                @php
                    $fields = [
                        'ayah' => ['label' => 'Ayah', 'icon_gender' => 'man', 'model' => $ayah ?? null],
                        'ibu' => ['label' => 'Ibu', 'icon_gender' => 'woman', 'model' => $ibu ?? null],
                    ];
                    $penghasilanOptions = [
                        'kurang_1jt' => '< Rp 1.000.000',
                        '1jt_3jt' => 'Rp 1 – 3 juta',
                        '3jt_5jt' => 'Rp 3 – 5 juta',
                        '5jt_10jt' => 'Rp 5 – 10 juta',
                        'lebih_10jt' => '> Rp 10 juta',
                    ];
                @endphp

                @foreach($fields as $key => $info)
                    <div>
                        <h3 class="text-base lg:text-lg font-bold mb-4 flex items-center gap-2 text-[#018B3E]">
                            <span class="material-symbols-outlined text-xl lg:text-2xl">{{ $info['icon_gender'] }}</span>
                            Data {{ $info['label'] }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap {{ $info['label'] }}
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                                    <input type="text" name="nama_{{ $key }}"
                                        value="{{ old('nama_' . $key, $info['model']->nama_lengkap ?? '') }}" required
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm rounded-xl outline-none transition-all @error('nama_' . $key) border-red-500 @enderror"
                                        style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="Nama lengkap {{ strtolower($info['label']) }}">
                                </div>
                                @error('nama_' . $key) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">NIK {{ $info['label'] }}</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">fingerprint</span>
                                    <input type="text" name="nik_{{ $key }}"
                                        value="{{ old('nik_' . $key, $info['model']->nik ?? '') }}" maxlength="16"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm rounded-xl outline-none transition-all @error('nik_' . $key) border-red-500 @enderror"
                                        style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="16 digit NIK" inputmode="numeric" pattern="[0-9]{16}"
                                        title="NIK harus 16 digit angka">
                                </div>
                                <p class="text-xs text-slate-400 mt-1">* NIK terdiri dari 16 digit angka</p>
                                @error('nik_' . $key) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon
                                    {{ $info['label'] }}</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">call</span>
                                    <input type="tel" name="telp_{{ $key }}"
                                        value="{{ old('telp_' . $key, $info['model']->no_telepon ?? '') }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm rounded-xl outline-none transition-all @error('telp_' . $key) border-red-500 @enderror"
                                        style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="Contoh: 081234567890" inputmode="numeric" pattern="[0-9]{10,13}"
                                        title="Nomor telepon harus terdiri dari 10-13 digit angka">
                                </div>
                                <p class="text-xs text-slate-400 mt-1">* Hanya angka, minimal 10 digit</p>
                                @error('telp_' . $key) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir
                                    {{ $info['label'] }}</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">location_on</span>
                                    <input type="text" name="tempat_lahir_{{ $key }}"
                                        value="{{ old('tempat_lahir_' . $key, $info['model']->tempat_lahir ?? '') }}"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm rounded-xl outline-none transition-all @error('tempat_lahir_' . $key) border-red-500 @enderror"
                                        style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="Tempat lahir {{ strtolower($info['label']) }}">
                                </div>
                                @error('tempat_lahir_' . $key) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir
                                    {{ $info['label'] }}</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">calendar_today</span>
                                    <input type="date" name="tanggal_lahir_{{ $key }}"
                                        value="{{ old('tanggal_lahir_' . $key, isset($info['model']->tanggal_lahir) ? \Carbon\Carbon::parse($info['model']->tanggal_lahir)->format('Y-m-d') : '') }}"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm rounded-xl outline-none transition-all @error('tanggal_lahir_' . $key) border-red-500 @enderror"
                                        style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                </div>
                                @error('tanggal_lahir_' . $key) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan
                                    {{ $info['label'] }}</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">work</span>
                                    <input type="text" name="pekerjaan_{{ $key }}"
                                        value="{{ old('pekerjaan_' . $key, $info['model']->pekerjaan ?? '') }}"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm rounded-xl outline-none transition-all @error('pekerjaan_' . $key) border-red-500 @enderror"
                                        style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                        placeholder="Contoh: Wiraswasta">
                                </div>
                                @error('pekerjaan_' . $key) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            @if($key === 'ayah')
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penghasilan Ayah</label>
                                    <div class="relative">
                                        <span
                                            class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">payments</span>
                                        <select name="penghasilan_ayah"
                                            class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm rounded-xl outline-none transition-all appearance-none @error('penghasilan_ayah') border-red-500 @enderror"
                                            style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                            onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                            <option value="">Pilih rentang penghasilan</option>
                                            @foreach($penghasilanOptions as $val => $lbl)
                                                <option value="{{ $val }}" {{ old('penghasilan_ayah', $ayah->penghasilan ?? '') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('penghasilan_ayah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat {{ $info['label'] }} (jika
                                    berbeda)</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3 lg:left-4 top-4 text-slate-400 text-xl">home</span>
                                    <textarea name="alamat_{{ $key }}" rows="2"
                                        class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm rounded-xl outline-none transition-all resize-none @error('alamat_' . $key) border-red-500 @enderror"
                                        style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                        onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">{{ old('alamat_' . $key, $info['model']->alamat ?? '') }}</textarea>
                                </div>
                                @error('alamat_' . $key) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    @if($key === 'ayah')
                    <hr class="border-slate-200 my-4 lg:my-6"> @endif
                @endforeach

                <div class="pt-6 lg:pt-8 flex flex-col-reverse sm:flex-row gap-3 lg:gap-4"
                    style="border-top:1px solid #f1f5f9;">
                    <a href="{{ route('siswa.pendaftaran.step2') }}"
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