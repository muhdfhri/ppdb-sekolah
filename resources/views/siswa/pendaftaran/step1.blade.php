@extends('layouts.siswa')

@section('title', 'Langkah 1 - Data Pribadi | PPDB SMK NU II Medan')
@section('breadcrumb_parent', 'Pendaftaran')
@section('breadcrumb', 'Langkah 1: Data Pribadi')
@section('header_sub', $pendaftaran?->nomor_pendaftaran ?? 'Belum mendaftar')

@section('content')
    <div class="space-y-6 lg:space-y-8 max-w-7xl w-full">

        @include('siswa.partials.stepper', ['currentStep' => 1])

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
                            <input type="text" 
                                   name="nik" 
                                   value="{{ old('nik', $siswa->nik ?? '') }}" 
                                   maxlength="16" 
                                   required
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all @error('nik') border-red-500 @enderror"
                                   style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                   onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                   placeholder="Masukkan 16 digit NIK"
                                   inputmode="numeric"
                                   pattern="[0-9]{16}"
                                   title="NIK harus 16 digit angka">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">* Harus 16 digit angka</p>
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap ?? '') }}" required
                                   class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all @error('nama_lengkap') border-red-500 @enderror"
                                   style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                   onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                   placeholder="Sesuai Akta Kelahiran / Ijazah">
                        </div>
                        @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">location_on</span>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}" required
                                   class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all @error('tempat_lahir') border-red-500 @enderror"
                                   style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                   onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                   placeholder="Contoh: Medan">
                        </div>
                        @error('tempat_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">calendar_today</span>
                            <input type="date" name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}"
                                   required
                                   class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all @error('tanggal_lahir') border-red-500 @enderror"
                                   style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                   onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                        </div>
                        @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        @php $jk = old('jenis_kelamin', $siswa->jenis_kelamin ?? ''); @endphp
                        <div class="grid grid-cols-2 gap-3 lg:gap-4">
                            @foreach(['Laki-laki' => 'male', 'Perempuan' => 'female'] as $val => $icon)
                                <label class="gender-label flex items-center justify-center gap-2 p-3 lg:p-4 rounded-xl border-2 cursor-pointer transition-all"
                                       style="border-color:{{ $jk == $val ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $jk == $val ? 'rgba(1,139,62,0.05)' : '#f8fafc' }};">
                                    <input type="radio" name="jenis_kelamin" value="{{ $val }}" class="sr-only"
                                           {{ $jk == $val ? 'checked' : '' }} onchange="updateGender(this)">
                                    <span class="material-symbols-outlined text-lg text-[#018B3E]">{{ $icon }}</span>
                                    <span class="font-medium text-slate-700 text-sm">{{ $val }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Agama --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Agama <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">church</span>
                            <select name="agama" required
                                    class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all appearance-none @error('agama') border-red-500 @enderror"
                                    style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                    onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                <option value="">Pilih Agama</option>
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
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
                            <input type="tel" 
                                   name="no_telepon" 
                                   value="{{ old('no_telepon', $siswa->no_telepon ?? '') }}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all @error('no_telepon') border-red-500 @enderror"
                                   style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                   onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                   placeholder="Contoh: 081234567890"
                                   inputmode="numeric"
                                   pattern="[0-9]{10,13}"
                                   title="Nomor telepon harus terdiri dari 10-13 digit angka">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">* Hanya angka, minimal 10 digit</p>
                        @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email (Locked from users table) --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', auth()->user()->email) }}" 
                                   readonly
                                   disabled
                                   class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none bg-slate-100 cursor-not-allowed"
                                   style="border:1px solid #e2e8f0; background-color:#f1f5f9; color:#64748b;">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">* Email tidak dapat diubah. Gunakan email saat registrasi akun.</p>
                    </div>

                    {{-- Alamat --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 lg:left-4 top-4 text-slate-400 text-xl">home</span>
                            <textarea name="alamat_lengkap" required rows="3"
                                      class="w-full pl-10 lg:pl-12 pr-4 py-3 lg:py-3.5 text-sm lg:text-base rounded-xl outline-none transition-all resize-none @error('alamat_lengkap') border-red-500 @enderror"
                                      style="border:1px solid #e2e8f0; background-color:#f8fafc;"
                                      onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.12)';"
                                      onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                                      placeholder="Nama Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan">{{ old('alamat_lengkap', $siswa->alamat_lengkap ?? '') }}</textarea>
                        </div>
                        @error('alamat_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Nav Buttons --}}
                <div class="pt-6 lg:pt-8 flex flex-col-reverse sm:flex-row gap-3 lg:gap-4" style="border-top:1px solid #f1f5f9;">
                    <a href="{{ route('siswa.pendaftaran.index') }}"
                        class="sm:flex-1 py-3 lg:py-4 px-6 rounded-xl font-bold text-sm lg:text-base text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                    </a>
                    <button type="submit"
                        class="sm:flex-[2] py-3 lg:py-4 px-6 rounded-xl font-bold text-sm lg:text-base text-white transition-all flex items-center justify-center gap-2"
                        style="background-color:#018B3E; box-shadow:0 8px 24px rgba(1,139,62,0.25);"
                        onmouseover="this.style.backgroundColor='#016b30';" onmouseout="this.style.backgroundColor='#018B3E';">
                        Lanjut ke Tahap Berikutnya <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    function updateGender(input) {
        document.querySelectorAll('.gender-label').forEach(label => {
            const r = label.querySelector('input[type="radio"]');
            label.style.borderColor     = r.checked ? '#018B3E' : '#f1f5f9';
            label.style.backgroundColor = r.checked ? 'rgba(1,139,62,0.05)' : '#f8fafc';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.gender-label input:checked').forEach(r => {
            r.closest('.gender-label').style.borderColor     = '#018B3E';
            r.closest('.gender-label').style.backgroundColor = 'rgba(1,139,62,0.05)';
        });
    });
    </script>
@endpush