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
                              @else 1 @endif,
                        files: {
                            ijazah: '',
                            kartu_keluarga: '',
                            akte_kelahiran: '',
                            pas_foto: '',
                            bukti_pembayaran: '',
                            kip: ''
                        },
                        handleFileChange(event, fieldName) {
                            const input = event.target;
                            const container = input.parentNode;
                            
                            // Remove existing error messages under this container
                            const existingErrors = container.querySelectorAll('.file-error-msg, .client-error-msg');
                            existingErrors.forEach(el => el.remove());
                            
                            if (!input.files || input.files.length === 0) {
                                this.files[fieldName] = '';
                                container.classList.remove('border-brand-primary', 'border-brand-secondary', 'ring-2', 'ring-amber-500/10');
                                container.classList.add('border-slate-300');
                                return;
                            }
                            
                            const file = input.files[0];
                            const maxFileSize = 2 * 1024 * 1024; // 2MB
                            const allowedExtensions = fieldName === 'pas_foto' ? ['.png', '.jpg', '.jpeg'] : ['.pdf', '.png', '.jpg', '.jpeg'];
                            const fileExt = '.' + file.name.split('.').pop().toLowerCase();
                            
                            if (file.size > maxFileSize) {
                                const errorEl = document.createElement('p');
                                errorEl.className = 'text-xs text-amber-700 font-bold mt-1.5 file-error-msg';
                                errorEl.textContent = 'Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.';
                                container.appendChild(errorEl);
                                
                                container.classList.remove('border-slate-300', 'border-brand-primary');
                                container.classList.add('border-brand-secondary', 'ring-2', 'ring-amber-500/10');
                                input.value = '';
                                this.files[fieldName] = '';
                                return;
                            }
                            
                            if (!allowedExtensions.includes(fileExt)) {
                                const errorEl = document.createElement('p');
                                errorEl.className = 'text-xs text-amber-700 font-bold mt-1.5 file-error-msg';
                                errorEl.textContent = 'Format berkas tidak didukung (' + (fieldName === 'pas_foto' ? 'JPG/PNG' : 'PDF/JPG/PNG') + ').';
                                container.appendChild(errorEl);
                                
                                container.classList.remove('border-slate-300', 'border-brand-primary');
                                container.classList.add('border-brand-secondary', 'ring-2', 'ring-amber-500/10');
                                input.value = '';
                                this.files[fieldName] = '';
                                return;
                            }
                            
                            container.classList.remove('border-brand-secondary', 'ring-2', 'ring-amber-500/10', 'border-slate-300');
                            container.classList.add('border-brand-primary');
                            this.files[fieldName] = file.name;
                        }
                    }"
                    x-init="$watch('step', value => window.scrollTo({top: 0, behavior: 'smooth'}))"
                    class="space-y-10">

                {{-- Header Title --}}
                <div class="text-center space-y-3">
                    <span
                        class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-brand-primary/10 text-brand-primary border border-brand-primary/20">
                        <span class="size-2 rounded-full bg-brand-primary animate-pulse"></span>
                        Formulir PPDB Online
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Pendaftaran Siswa Baru
                    </h1>
                    <p class="text-sm text-slate-500 font-medium max-w-md mx-auto">
                        Tahun Pelajaran <span
                            class="text-brand-primary font-bold">{{ $periode->tahun_ajaran ?? '2026/2027' }}</span> • SMK NU
                        II Medan
                    </p>
                </div>

                {{-- Alert Global Errors --}}
                @if($errors->any())
                    <div
                        class="flex items-start gap-3.5 p-5 rounded-2xl text-sm bg-amber-50 border border-amber-200 text-amber-800 shadow-sm animate-shake">
                        <span class="material-symbols-outlined shrink-0 mt-0.5 text-xl text-amber-600">error</span>
                        <div class="flex-1">
                            <span class="font-extrabold block mb-1 text-amber-950">Mohon Perbaiki Kesalahan Berikut:</span>
                            <ul class="list-disc list-inside space-y-1 text-xs text-amber-800 font-medium">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Stepper Indicator --}}
                <div class="relative flex justify-between items-center max-w-md mx-auto mb-16 px-4 z-0">
                    {{-- Progress Line Background --}}
                    <div class="absolute left-9 right-9 top-5 h-1 bg-slate-200 rounded-full z-0"></div>
                    {{-- Progress Line Active --}}
                    <div class="absolute left-9 top-5 h-1 bg-brand-primary rounded-full transition-all duration-500 ease-out z-0 shadow-[0_0_12px_rgba(1,139,62,0.3)]"
                        :style="'width: calc(' + ((step - 1) * 50) + '% - ' + ((step - 1) * 36) + 'px)'"></div>

                    {{-- Step 1: Biodata --}}
                    <div class="flex flex-col items-center z-10">
                        <div @click="if(step > 1) step = 1"
                            class="size-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 shadow-md cursor-pointer focus:outline-none select-none"
                            :class="step >= 1 ? 'bg-brand-primary text-white ring-4 ring-brand-primary/20 scale-105' : 'bg-white border-2 border-slate-200 text-slate-400'">
                            <span x-show="step > 1" class="material-symbols-outlined text-base">check</span>
                            <span x-show="step <= 1">1</span>
                        </div>
                        <span
                            class="text-[11px] font-extrabold uppercase tracking-wider mt-2.5 transition-colors duration-300"
                            :class="step >= 1 ? 'text-brand-primary' : 'text-slate-400'">Biodata</span>
                    </div>

                    {{-- Step 2: Akademik --}}
                    <div class="flex flex-col items-center z-10">
                        <div @click="if(step > 2) step = 2"
                            class="size-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 shadow-md cursor-pointer focus:outline-none select-none"
                            :class="step >= 2 ? 'bg-brand-primary text-white ring-4 ring-brand-primary/20 scale-105' : 'bg-white border-2 border-slate-200 text-slate-400'">
                            <span x-show="step > 2" class="material-symbols-outlined text-base">check</span>
                            <span x-show="step <= 2">2</span>
                        </div>
                        <span
                            class="text-[11px] font-extrabold uppercase tracking-wider mt-2.5 transition-colors duration-300"
                            :class="step >= 2 ? 'text-brand-primary' : 'text-slate-400'">Akademik</span>
                    </div>

                    {{-- Step 3: Berkas --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="size-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 shadow-sm select-none"
                            :class="step >= 3 ? 'bg-brand-primary text-white ring-4 ring-brand-primary/20 scale-105' : 'bg-white border-2 border-slate-200 text-slate-400'">
                            <span>3</span>
                        </div>
                        <span
                            class="text-[11px] font-extrabold uppercase tracking-wider mt-2.5 transition-colors duration-300"
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
                    <div x-show="step === 1" class="space-y-8" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">

                        {{-- Card A: Data Pribadi --}}
                        <div
                            class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_12px_24px_-10px_rgba(0,0,0,0.02),0_4px_12px_-4px_rgba(1,139,62,0.01)] border border-slate-100 space-y-6">
                            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                                <div
                                    class="size-11 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                                    <span class="material-symbols-outlined text-2xl font-semibold">person</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">A. Data Pribadi Calon Siswa</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Lengkapi identitas diri calon siswa sesuai
                                        dengan dokumen resmi.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Nama Lengkap --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama
                                        Lengkap <span class="text-error">*</span></label>
                                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                        placeholder="Sesuai Akta Kelahiran / Ijazah">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Tulis nama lengkap dengan huruf kapital sesuai Akta/Ijazah</p>
                                </div>

                                {{-- NIK --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK
                                        <span class="text-error">*</span></label>
                                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                        placeholder="16 Digit NIK Calon Siswa">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Harus 16 digit angka sesuai
                                        Kartu Keluarga</p>
                                </div>

                                {{-- Tempat Lahir --}}
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tempat
                                        Lahir <span class="text-error">*</span></label>
                                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                        placeholder="Contoh: Medan">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Contoh: Medan</p>
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal
                                        Lahir <span class="text-error">*</span></label>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold cursor-pointer">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Sesuaikan dengan dokumen resmi</p>
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis
                                        Kelamin <span class="text-error">*</span></label>
                                    <select name="jenis_kelamin" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23475569%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat cursor-pointer">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>

                                {{-- Agama --}}
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Agama
                                        <span class="text-error">*</span></label>
                                    <select name="agama" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23475569%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat cursor-pointer">
                                        <option value="">Pilih Agama</option>
                                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                            <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>
                                                {{ $agama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- No Telepon --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No.
                                        Telepon / WhatsApp <span class="text-error">*</span></label>
                                    <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                        placeholder="Contoh: 081234567890">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Harus berupa 9-15 digit angka aktif</p>
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email
                                        <span class="text-error">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                        placeholder="Contoh: siswa@gmail.com">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Gunakan alamat email aktif siswa/orang tua</p>
                                </div>

                                {{-- Alamat Lengkap --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat
                                        Lengkap <span class="text-error">*</span></label>
                                    <textarea name="alamat_lengkap" rows="3" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400 resize-none"
                                        placeholder="Nama Jalan, Blok, RT/RW, Kelurahan, Kecamatan, Kabupaten/Kota">{{ old('alamat_lengkap') }}</textarea>
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Tulis lengkap (Nama Jalan, Blok, RT/RW, Kelurahan, Kecamatan, Kab/Kota, minimal 10 karakter)</p>
                                </div>
                            </div>
                        </div>

                        {{-- Card B: Sekolah Asal --}}
                        <div
                            class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_12px_24px_-10px_rgba(0,0,0,0.02),0_4px_12px_-4px_rgba(1,139,62,0.01)] border border-slate-100 space-y-6">
                            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                                <div
                                    class="size-11 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                                    <span class="material-symbols-outlined text-2xl font-semibold">school</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">B. Data Sekolah Asal</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Lengkapi data sekolah jenjang sebelumnya
                                        (SMP/MTs/Sederajat).</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Nama Sekolah --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama
                                        Sekolah Asal <span class="text-error">*</span></label>
                                    <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                        placeholder="Contoh: SMP Negeri 1 Medan">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Contoh: SMP Negeri 1 Medan</p>
                                </div>

                                {{-- NISN --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NISN
                                        <span class="text-error">*</span></label>
                                    <input type="text" name="nisn" value="{{ old('nisn') }}" maxlength="20" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                        placeholder="Masukkan NISN">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Masukkan 8-20 digit NISN resmi</p>
                                </div>

                                {{-- Tahun Lulus --}}
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun
                                        Lulus <span class="text-error">*</span></label>
                                    <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', date('Y')) }}"
                                        required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Tahun kelulusan jenjang sebelumnya</p>
                                </div>

                                {{-- Nilai Rata-rata Rapor --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nilai
                                        Rata-rata Rapor / Ijazah <span class="text-error">*</span></label>
                                    <input type="number" step="0.01" name="nilai_rata_rata"
                                        value="{{ old('nilai_rata_rata') }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                        placeholder="Contoh: 85.50">
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Skala 0-100, contoh: 85.50</p>
                                </div>

                                {{-- Alamat Sekolah --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat
                                        Sekolah Asal <span class="text-error">*</span></label>
                                    <textarea name="alamat_sekolah" rows="2" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400 resize-none"
                                        placeholder="Masukkan kota/kecamatan alamat sekolah asal">{{ old('alamat_sekolah') }}</textarea>
                                    <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Masukkan kota/kecamatan asal sekolah, minimal 5 karakter</p>
                                </div>
                            </div>
                        </div>

                        {{-- Card C: Data Orang Tua --}}
                        <div
                            class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_12px_24px_-10px_rgba(0,0,0,0.02),0_4px_12px_-4px_rgba(1,139,62,0.01)] border border-slate-100 space-y-8">
                            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                                <div
                                    class="size-11 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                                    <span class="material-symbols-outlined text-2xl font-semibold">family_restroom</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">C. Data Orang Tua Calon Siswa</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Lengkapi data orang tua kandung sesuai dengan
                                        KTP / KK.</p>
                                </div>
                            </div>

                            {{-- Sub-Card C1: Data Ayah --}}
                            <div class="space-y-5 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
                                <h4
                                    class="text-xs font-extrabold uppercase tracking-widest text-brand-primary flex items-center gap-2">
                                    <span class="size-2 rounded-full bg-brand-primary"></span>
                                    1. Data Ayah Kandung
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="col-span-1 md:col-span-2">
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama
                                            Lengkap Ayah <span class="text-error">*</span></label>
                                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="Nama lengkap sesuai KK/KTP">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK
                                            Ayah <span class="text-error">*</span></label>
                                        <input type="text" name="nik_ayah" value="{{ old('nik_ayah') }}" maxlength="16"
                                            required oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="16 Digit NIK Ayah">
                                        <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Harus 16 digit angka sesuai KTP/KK</p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No.
                                            HP / WhatsApp Ayah <span class="text-error">*</span></label>
                                        <input type="tel" name="telp_ayah" value="{{ old('telp_ayah') }}" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="Contoh: 081234567890">
                                        <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Harus berupa angka aktif, contoh: 081234567890</p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tempat
                                            Lahir Ayah <span class="text-error">*</span></label>
                                        <input type="text" name="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="Tempat Lahir Ayah">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal
                                            Lahir Ayah <span class="text-error">*</span></label>
                                        <input type="date" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold cursor-pointer">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pekerjaan
                                            Ayah <span class="text-error">*</span></label>
                                        <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="Contoh: Wiraswasta, PNS, Karyawan">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Penghasilan
                                            Bulanan Ayah <span class="text-error">*</span></label>
                                        <select name="penghasilan_ayah" required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23475569%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat cursor-pointer">
                                            <option value="">Pilih Penghasilan</option>
                                            <option value="kurang_1jt" {{ old('penghasilan_ayah') == 'kurang_1jt' ? 'selected' : '' }}>Kurang dari Rp 1.000.000</option>
                                            <option value="1jt_3jt" {{ old('penghasilan_ayah') == '1jt_3jt' ? 'selected' : '' }}>Rp 1.000.000 - Rp 3.000.000</option>
                                            <option value="3jt_5jt" {{ old('penghasilan_ayah') == '3jt_5jt' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                            <option value="5jt_10jt" {{ old('penghasilan_ayah') == '5jt_10jt' ? 'selected' : '' }}>Rp 5.000.000 - Rp 10.000.000</option>
                                            <option value="lebih_10jt" {{ old('penghasilan_ayah') == 'lebih_10jt' ? 'selected' : '' }}>Lebih dari Rp 10.000.000</option>
                                        </select>
                                    </div>

                                    <div class="col-span-1 md:col-span-2">
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat
                                            Ayah <span class="text-error">*</span></label>
                                        <textarea name="alamat_ayah" rows="2" required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400 resize-none"
                                            placeholder="Alamat lengkap ayah kandung">{{ old('alamat_ayah') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            {{-- Sub-Card C2: Data Ibu --}}
                            <div class="space-y-5 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
                                <h4
                                    class="text-xs font-extrabold uppercase tracking-widest text-brand-primary flex items-center gap-2">
                                    <span class="size-2 rounded-full bg-brand-primary"></span>
                                    2. Data Ibu Kandung
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="col-span-1 md:col-span-2">
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama
                                            Lengkap Ibu <span class="text-error">*</span></label>
                                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="Nama lengkap sesuai KK/KTP">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK
                                            Ibu <span class="text-error">*</span></label>
                                        <input type="text" name="nik_ibu" value="{{ old('nik_ibu') }}" maxlength="16"
                                            required oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="16 Digit NIK Ibu">
                                        <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Harus 16 digit angka sesuai KTP/KK</p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No.
                                            HP / WhatsApp Ibu <span class="text-error">*</span></label>
                                        <input type="tel" name="telp_ibu" value="{{ old('telp_ibu') }}" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="Contoh: 081234567890">
                                        <p class="text-[10px] text-slate-400 font-medium mt-1.5">* Harus berupa angka aktif, contoh: 081234567890</p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tempat
                                            Lahir Ibu <span class="text-error">*</span></label>
                                        <input type="text" name="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="Tempat Lahir Ibu">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal
                                            Lahir Ibu <span class="text-error">*</span></label>
                                        <input type="date" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}"
                                            required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold cursor-pointer">
                                    </div>

                                    <div class="col-span-1 md:col-span-2">
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pekerjaan
                                            Ibu <span class="text-error">*</span></label>
                                        <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400"
                                            placeholder="Contoh: Ibu Rumah Tangga, Guru, Wiraswasta">
                                    </div>

                                    <div class="col-span-1 md:col-span-2">
                                        <label
                                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat
                                            Ibu <span class="text-error">*</span></label>
                                        <textarea name="alamat_ibu" rows="2" required
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 outline-none focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold placeholder:text-slate-400 resize-none"
                                            placeholder="Alamat lengkap ibu kandung">{{ old('alamat_ibu') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Nav Button Step 1 --}}
                        <div class="pt-6 flex justify-end">
                            <button type="button" @click="if(window.validateStep(1)) step = 2"
                                class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-white transition-all flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-primary/95 shadow-md shadow-brand-primary/20 hover:-translate-y-0.5 active:translate-y-0 duration-200 cursor-pointer">
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

                        <div
                            class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_12px_24px_-10px_rgba(0,0,0,0.02),0_4px_12px_-4px_rgba(1,139,62,0.01)] border border-slate-100 space-y-6">
                            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                                <div
                                    class="size-11 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                                    <span class="material-symbols-outlined text-2xl font-semibold">school</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">Pilihan Jurusan</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Tentukan prioritas program keahlian yang ingin
                                        Anda tempuh di SMK NU II Medan.</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                {{-- Pilihan 1 --}}
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jurusan
                                        Pilihan Utama <span class="text-error">*</span></label>
                                    <select name="jurusan_id" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23475569%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat cursor-pointer">
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
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jurusan
                                        Pilihan Kedua (Cadangan)</label>
                                    <select name="jurusan_id_2"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 outline-none hover:bg-slate-50 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-semibold appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23475569%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat cursor-pointer">
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
                                class="sm:flex-1 py-3.5 px-6 rounded-xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all flex items-center justify-center gap-2 duration-200 cursor-pointer">
                                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                            </button>
                            <button type="button" @click="if(window.validateStep(2)) step = 3"
                                class="sm:flex-[2] py-3.5 px-6 rounded-xl font-bold text-white transition-all flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-primary/95 shadow-md shadow-brand-primary/20 hover:-translate-y-0.5 active:translate-y-0 duration-200 cursor-pointer">
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

                        <div
                            class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_12px_24px_-10px_rgba(0,0,0,0.02),0_4px_12px_-4px_rgba(1,139,62,0.01)] border border-slate-100 space-y-6">
                            <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
                                <div
                                    class="size-11 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                                    <span class="material-symbols-outlined text-2xl font-semibold">folder_zip</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">Upload Dokumen Persyaratan</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Unggah pindaian berkas pendukung dalam format
                                        PDF atau Gambar (Maks. 2MB per file).</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Ijazah --}}
                                <div class="relative group cursor-pointer border border-dashed rounded-2xl p-5 transition-all duration-200 flex flex-col items-center justify-center text-center bg-slate-50/30 hover:bg-slate-50 border-slate-300"
                                    :class="files.ijazah ? 'border-brand-primary bg-brand-primary/[0.01]' : 'border-slate-300 hover:border-brand-primary/60'">
                                    <input type="file" name="ijazah" required
                                        accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        @change="handleFileChange($event, 'ijazah')"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="size-11 rounded-full flex items-center justify-center mb-2.5 transition-all"
                                        :class="files.ijazah ? 'bg-brand-primary/10 text-brand-primary' : 'bg-slate-100 text-slate-400 group-hover:bg-brand-primary/10 group-hover:text-brand-primary'">
                                        <span class="material-symbols-outlined text-xl"
                                            x-text="files.ijazah ? 'task' : 'cloud_upload'">cloud_upload</span>
                                    </div>
                                    <span class="block text-xs font-bold text-slate-700">Ijazah / SKL (Asli/Legalisir) <span
                                            class="text-brand-secondary font-extrabold">*</span></span>
                                    <span class="text-[9px] text-slate-500 font-semibold block mt-0.5">Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</span>
                                    <p class="text-[10px] mt-1.5 font-medium truncate max-w-full px-2"
                                        :class="files.ijazah ? 'text-brand-primary font-bold' : 'text-slate-400'"
                                        x-text="files.ijazah ? files.ijazah : 'Seret berkas atau klik untuk memilih'"></p>
                                </div>

                                {{-- Kartu Keluarga --}}
                                <div class="relative group cursor-pointer border border-dashed rounded-2xl p-5 transition-all duration-200 flex flex-col items-center justify-center text-center bg-slate-50/30 hover:bg-slate-50 border-slate-300"
                                    :class="files.kartu_keluarga ? 'border-brand-primary bg-brand-primary/[0.01]' : 'border-slate-300 hover:border-brand-primary/60'">
                                    <input type="file" name="kartu_keluarga" required
                                        accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        @change="handleFileChange($event, 'kartu_keluarga')"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="size-11 rounded-full flex items-center justify-center mb-2.5 transition-all"
                                        :class="files.kartu_keluarga ? 'bg-brand-primary/10 text-brand-primary' : 'bg-slate-100 text-slate-400 group-hover:bg-brand-primary/10 group-hover:text-brand-primary'">
                                        <span class="material-symbols-outlined text-xl"
                                            x-text="files.kartu_keluarga ? 'task' : 'cloud_upload'">cloud_upload</span>
                                    </div>
                                    <span class="block text-xs font-bold text-slate-700">Kartu Keluarga (KK) <span
                                            class="text-brand-secondary font-extrabold">*</span></span>
                                    <span class="text-[9px] text-slate-500 font-semibold block mt-0.5">Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</span>
                                    <p class="text-[10px] mt-1.5 font-medium truncate max-w-full px-2"
                                        :class="files.kartu_keluarga ? 'text-brand-primary font-bold' : 'text-slate-400'"
                                        x-text="files.kartu_keluarga ? files.kartu_keluarga : 'Seret berkas atau klik untuk memilih'">
                                    </p>
                                </div>

                                {{-- Akta Kelahiran --}}
                                <div class="relative group cursor-pointer border border-dashed rounded-2xl p-5 transition-all duration-200 flex flex-col items-center justify-center text-center bg-slate-50/30 hover:bg-slate-50 border-slate-300"
                                    :class="files.akte_kelahiran ? 'border-brand-primary bg-brand-primary/[0.01]' : 'border-slate-300 hover:border-brand-primary/60'">
                                    <input type="file" name="akte_kelahiran" required
                                        accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        @change="handleFileChange($event, 'akte_kelahiran')"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="size-11 rounded-full flex items-center justify-center mb-2.5 transition-all"
                                        :class="files.akte_kelahiran ? 'bg-brand-primary/10 text-brand-primary' : 'bg-slate-100 text-slate-400 group-hover:bg-brand-primary/10 group-hover:text-brand-primary'">
                                        <span class="material-symbols-outlined text-xl"
                                            x-text="files.akte_kelahiran ? 'task' : 'cloud_upload'">cloud_upload</span>
                                    </div>
                                    <span class="block text-xs font-bold text-slate-700">Akta Kelahiran <span
                                            class="text-brand-secondary font-extrabold">*</span></span>
                                    <span class="text-[9px] text-slate-500 font-semibold block mt-0.5">Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</span>
                                    <p class="text-[10px] mt-1.5 font-medium truncate max-w-full px-2"
                                        :class="files.akte_kelahiran ? 'text-brand-primary font-bold' : 'text-slate-400'"
                                        x-text="files.akte_kelahiran ? files.akte_kelahiran : 'Seret berkas atau klik untuk memilih'">
                                    </p>
                                </div>

                                {{-- Pas Foto --}}
                                <div class="relative group cursor-pointer border border-dashed rounded-2xl p-5 transition-all duration-200 flex flex-col items-center justify-center text-center bg-slate-50/30 hover:bg-slate-50 border-slate-300"
                                    :class="files.pas_foto ? 'border-brand-primary bg-brand-primary/[0.01]' : 'border-slate-300 hover:border-brand-primary/60'">
                                    <input type="file" name="pas_foto" required accept="image/png,image/jpeg,image/jpg"
                                        @change="handleFileChange($event, 'pas_foto')"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="size-11 rounded-full flex items-center justify-center mb-2.5 transition-all"
                                        :class="files.pas_foto ? 'bg-brand-primary/10 text-brand-primary' : 'bg-slate-100 text-slate-400 group-hover:bg-brand-primary/10 group-hover:text-brand-primary'">
                                        <span class="material-symbols-outlined text-xl"
                                            x-text="files.pas_foto ? 'task' : 'cloud_upload'">cloud_upload</span>
                                    </div>
                                    <span class="block text-xs font-bold text-slate-700">Pas Foto 3x4 (Bg Merah/Biru) <span
                                            class="text-brand-secondary font-extrabold">*</span></span>
                                    <span class="text-[9px] text-slate-500 font-semibold block mt-0.5">Format: JPG, JPEG, PNG (Maks. 2MB)</span>
                                    <p class="text-[10px] mt-1.5 font-medium truncate max-w-full px-2"
                                        :class="files.pas_foto ? 'text-brand-primary font-bold' : 'text-slate-400'"
                                        x-text="files.pas_foto ? files.pas_foto : 'Seret berkas atau klik untuk memilih'">
                                    </p>
                                </div>

                                {{-- Bukti Pembayaran --}}
                                <div class="relative group cursor-pointer border border-dashed rounded-2xl p-5 transition-all duration-200 flex flex-col items-center justify-center text-center bg-slate-50/30 hover:bg-slate-50 border-slate-300"
                                    :class="files.bukti_pembayaran ? 'border-brand-primary bg-brand-primary/[0.01]' : 'border-slate-300 hover:border-brand-primary/60'">
                                    <input type="file" name="bukti_pembayaran" required
                                        accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        @change="handleFileChange($event, 'bukti_pembayaran')"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="size-11 rounded-full flex items-center justify-center mb-2.5 transition-all"
                                        :class="files.bukti_pembayaran ? 'bg-brand-primary/10 text-brand-primary' : 'bg-slate-100 text-slate-400 group-hover:bg-brand-primary/10 group-hover:text-brand-primary'">
                                        <span class="material-symbols-outlined text-xl"
                                            x-text="files.bukti_pembayaran ? 'task' : 'cloud_upload'">cloud_upload</span>
                                    </div>
                                    <span class="block text-xs font-bold text-slate-700">Bukti Pembayaran Registrasi <span
                                            class="text-brand-secondary font-extrabold">*</span></span>
                                    <span class="text-[9px] text-slate-500 font-semibold block mt-0.5">Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</span>
                                    <p class="text-[10px] mt-1.5 font-medium truncate max-w-full px-2"
                                        :class="files.bukti_pembayaran ? 'text-brand-primary font-bold' : 'text-slate-400'"
                                        x-text="files.bukti_pembayaran ? files.bukti_pembayaran : 'Seret berkas atau klik untuk memilih'">
                                    </p>
                                </div>

                                {{-- KIP --}}
                                <div class="relative group cursor-pointer border border-dashed rounded-2xl p-5 transition-all duration-200 flex flex-col items-center justify-center text-center bg-slate-50/30 hover:bg-slate-50 border-slate-300"
                                    :class="files.kip ? 'border-brand-primary bg-brand-primary/[0.01]' : 'border-slate-300 hover:border-brand-primary/60'">
                                    <input type="file" name="kip" accept="application/pdf,image/png,image/jpeg,image/jpg"
                                        @change="handleFileChange($event, 'kip')"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="size-11 rounded-full flex items-center justify-center mb-2.5 transition-all"
                                        :class="files.kip ? 'bg-brand-primary/10 text-brand-primary' : 'bg-slate-100 text-slate-400 group-hover:bg-brand-primary/10 group-hover:text-brand-primary'">
                                        <span class="material-symbols-outlined text-xl"
                                            x-text="files.kip ? 'task' : 'cloud_upload'">cloud_upload</span>
                                    </div>
                                    <span class="block text-xs font-bold text-slate-700">Kartu Indonesia Pintar (KIP)</span>
                                    <span class="text-[9px] text-slate-500 font-semibold block mt-0.5">Format: PDF, JPG, JPEG, PNG (Maks. 2MB) (Opsional)</span>
                                    <p class="text-[10px] mt-1.5 font-medium truncate max-w-full px-2"
                                        :class="files.kip ? 'text-brand-primary font-bold' : 'text-slate-400'"
                                        x-text="files.kip ? files.kip : 'Seret berkas atau klik untuk memilih (Opsional)'">
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Finalisasi Confirmation --}}
                        <div
                            class="bg-amber-50/60 rounded-3xl p-6 border border-amber-200 shadow-[0_4px_16px_rgba(246,203,4,0.02)]">
                            <label class="flex items-start gap-3.5 cursor-pointer select-none">
                                <input type="checkbox" required
                                    class="checkbox mt-1 rounded-lg border-slate-700 border-2 bg-white checked:bg-brand-primary checked:border-brand-primary focus:ring-offset-0 focus:ring-brand-primary">
                                <span class="text-xs sm:text-sm text-slate-700 font-semibold leading-relaxed">
                                    Saya menyatakan bahwa seluruh data yang diisi dan berkas yang diupload adalah benar,
                                    sah, dan sesuai dengan berkas asli. Saya bertanggung jawab penuh atas kebenaran data
                                    ini.
                                </span>
                            </label>
                        </div>

                        {{-- Nav Buttons Step 3 --}}
                        <div class="pt-6 flex flex-col-reverse sm:flex-row gap-3">
                            <button type="button" @click="step = 2"
                                class="sm:flex-1 py-3.5 px-6 rounded-xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all flex items-center justify-center gap-2 duration-200 cursor-pointer">
                                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                            </button>
                            <button type="submit"
                                class="sm:flex-[2] py-3.5 px-6 rounded-xl font-bold text-white transition-all flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-primary/95 shadow-md shadow-brand-primary/20 hover:-translate-y-0.5 active:translate-y-0 duration-200 cursor-pointer">
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
                        targetElement.classList.remove('border-slate-200', 'border-brand-primary');
                        targetElement.classList.add('border-brand-secondary', 'ring-2', 'ring-amber-500/10');

                        const errorEl = document.createElement('p');
                        errorEl.className = 'text-xs text-amber-700 font-bold mt-1 client-error-msg';
                        errorEl.textContent = errorMessage;
                        input.parentNode.appendChild(errorEl);

                        const clearError = () => {
                            targetElement.classList.remove('border-brand-secondary', 'ring-2', 'ring-amber-500/10');
                            targetElement.classList.add('border-slate-200');
                            errorEl.remove();
                        };
                        input.addEventListener('input', clearError, { once: true });
                        input.addEventListener('change', clearError, { once: true });
                    }
                });

                if (!isValid && window.showToast) {
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
    <style>
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-4px);
            }

            75% {
                transform: translateX(4px);
            }
        }

        .animate-shake {
            animation: shake 0.3s ease-in-out;
        }
    </style>
@endpush