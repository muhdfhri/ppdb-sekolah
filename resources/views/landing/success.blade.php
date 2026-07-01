@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - SMK NU II Medan')

@section('content')
    @include('partials.navbar')

    <div class="min-h-screen py-16 bg-background-light flex items-center justify-center">

        <div class="max-w-2xl w-full px-4 sm:px-6 lg:px-8">

            {{-- Success Card --}}
            <div class="bg-white rounded-3xl shadow-[0_32px_64px_-15px_rgba(1,139,62,0.08),0_4px_20px_-2px_rgba(1,139,62,0.04)] border border-slate-100 overflow-hidden transition-all duration-300 hover:shadow-[0_40px_80px_-12px_rgba(1,139,62,0.12)]">

                {{-- Top Banner --}}
                <div class="px-8 py-12 text-center bg-gradient-to-br from-brand-primary via-[#018b3e]/95 to-[#005e29] relative overflow-hidden">
                    {{-- Decorative pattern overlay --}}
                    <div class="absolute inset-0 opacity-10 pointer-events-none select-none bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                    
                    {{-- Animated Check Icon --}}
                    <div class="relative size-24 rounded-full mx-auto flex items-center justify-center mb-6">
                        <div class="absolute inset-0 rounded-full bg-brand-secondary/20 animate-ping opacity-75"></div>
                        <div class="relative size-20 rounded-full bg-brand-secondary/15 flex items-center justify-center border-2 border-brand-secondary/30 shadow-[0_0_24px_rgba(246,203,4,0.3)]">
                            <span class="material-symbols-outlined text-5xl text-brand-secondary select-none" style="animation: popIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;">
                                check_circle
                            </span>
                        </div>
                    </div>

                    <h1 class="text-3xl font-extrabold text-white mb-2 tracking-tight">Pendaftaran Berhasil!</h1>
                    <p class="text-sm font-medium tracking-wide text-brand-secondary/90 max-w-md mx-auto">
                        Formulir PPDB Online SMK NU II Medan telah berhasil kami terima.
                    </p>
                </div>

                {{-- Body Content --}}
                <div class="px-8 py-8 space-y-6">

                    {{-- Nomor Pendaftaran Highlight with Copy --}}
                    <div class="relative rounded-2xl p-6 text-center border border-brand-primary/15 bg-brand-primary/[0.03] overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 size-40 bg-brand-primary/5 rounded-full blur-2xl transition-all duration-500 group-hover:bg-brand-primary/10"></div>
                        
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-2">Nomor Pendaftaran Anda</p>
                        
                        <div class="flex items-center justify-center gap-3">
                            <span id="reg-number" class="text-3xl font-black tracking-widest font-mono text-brand-primary">
                                {{ $pendaftaran->nomor_pendaftaran ?? '-' }}
                            </span>
                            <button id="copy-btn" onclick="copyRegNumber()" class="inline-flex items-center justify-center size-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-brand-primary hover:border-brand-primary hover:shadow-sm active:scale-95 transition-all duration-200 cursor-pointer" title="Salin Nomor Pendaftaran">
                                <span class="material-symbols-outlined text-lg">content_copy</span>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-2">Simpan nomor ini untuk keperluan verifikasi berkas dan pencarian data.</p>
                    </div>

                    {{-- Student Info Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 rounded-2xl p-5 bg-slate-50 border border-slate-100">
                        @php $nama = $pendaftaran->siswa->nama_lengkap ?? $pendaftaran->nama_lengkap ?? '-'; @endphp

                        <div class="flex items-center gap-3">
                            <div class="size-10 rounded-xl bg-brand-primary/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-brand-primary text-xl">person</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Pendaftar</p>
                                <p class="text-sm font-bold text-slate-800 truncate" title="{{ $nama }}">{{ $nama }}</p>
                            </div>
                        </div>

                        @if($pendaftaran->jurusan)
                        <div class="flex items-center gap-3">
                            <div class="size-10 rounded-xl bg-brand-primary/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-brand-primary text-xl">school</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pilihan Jurusan Utama</p>
                                <p class="text-sm font-bold text-slate-800 truncate" title="{{ $pendaftaran->jurusan->nama_jurusan }}">{{ $pendaftaran->jurusan->nama_jurusan }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center gap-3">
                            <div class="size-10 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-amber-500 text-xl">hourglass_empty</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status Pendaftaran</p>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="size-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    <span class="text-xs font-bold text-amber-600 uppercase tracking-wide">Menunggu Verifikasi</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="size-10 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-slate-500 text-xl">calendar_today</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tanggal Daftar</p>
                                <p class="text-sm font-bold text-slate-800">
                                    {{ $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->translatedFormat('d M Y, H:i') . ' WIB' : now()->translatedFormat('d M Y, H:i') . ' WIB' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- What's Next Timeline Section --}}
                    <div class="space-y-4">
                        <h3 class="text-xs font-extrabold uppercase tracking-widest text-slate-400 flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">checklist</span> Langkah Selanjutnya
                        </h3>
                        
                        <div class="relative pl-8 space-y-5 before:absolute before:left-4 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-100">
                            @php
                                $steps = [
                                    ['icon' => 'save', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50', 'border' => 'border-blue-100', 'title' => 'Simpan Bukti Nomor Pendaftaran', 'desc' => 'Salin nomor pendaftaran di atas atau simpan kartu pendaftaran Anda untuk proses berikutnya.'],
                                    ['icon' => 'pending_actions', 'color' => 'text-amber-600', 'bg' => 'bg-amber-50', 'border' => 'border-amber-100', 'title' => 'Verifikasi Berkas Calon Siswa', 'desc' => 'Panitia PPDB SMK NU II Medan akan memeriksa validitas berkas fisik/digital dalam 1-3 hari kerja.'],
                                    ['icon' => 'campaign', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-50', 'border' => 'border-emerald-100', 'title' => 'Pantau Pengumuman Hasil Seleksi', 'desc' => 'Lihat status kelulusan berkas secara berkala melalui menu halaman pengumuman publik.'],
                                ];
                            @endphp
                            
                            @foreach($steps as $i => $s)
                                <div class="relative group">
                                    {{-- Timeline bullet --}}
                                    <div class="absolute -left-8 top-1.5 size-8 rounded-full border-2 border-white bg-slate-100 text-slate-500 font-bold text-xs flex items-center justify-center transition-all group-hover:border-brand-primary group-hover:bg-brand-primary/5 group-hover:text-brand-primary">
                                        {{ $i + 1 }}
                                    </div>
                                    
                                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-[0_2px_8px_-2px_rgba(0,0,0,0.02)] transition-all duration-200 hover:shadow-md hover:border-slate-200">
                                        <div class="size-10 rounded-xl {{ $s['bg'] }} border {{ $s['border'] }} flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-lg {{ $s['color'] }}">{{ $s['icon'] }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ $s['title'] }}</p>
                                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $s['desc'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Contact Info Widget --}}
                    <div class="rounded-2xl p-4 border border-brand-primary/10 bg-brand-primary/[0.02] flex gap-3">
                        <span class="material-symbols-outlined text-brand-primary text-xl shrink-0 mt-0.5">contact_support</span>
                        <div>
                            <p class="text-xs font-bold text-slate-700 uppercase tracking-wide">Butuh Bantuan Informasi?</p>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Apabila ada ketidaksesuaian data atau pertanyaan lebih lanjut, silakan hubungi Customer Service PPDB di nomor WhatsApp resmi sekolah atau berkunjung ke panitia PPDB SMK NU II Medan.
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Footer Actions --}}
                <div class="px-8 pb-8 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('landing.pendaftaran.cetak', $pendaftaran->id) }}"
                       class="flex-1 flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-sm text-slate-900 bg-brand-secondary hover:bg-[#ebd03c] transition-all duration-200 shadow-md hover:-translate-y-0.5 active:translate-y-0 text-center">
                        <span class="material-symbols-outlined text-lg">download</span>
                        Unduh Kartu
                    </a>
                    <a href="{{ route('pengumuman.publik') }}"
                       class="flex-1 flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-sm border-2 border-brand-primary text-brand-primary hover:bg-brand-primary/5 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 text-center">
                        <span class="material-symbols-outlined text-lg">campaign</span>
                        Pengumuman
                    </a>
                    <a href="{{ route('home') }}"
                       class="flex-1 flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-sm text-white bg-brand-primary hover:bg-brand-primary/95 transition-all duration-200 shadow-md hover:-translate-y-0.5 active:translate-y-0 text-center">
                        <span class="material-symbols-outlined text-lg">home</span>
                        Ke Beranda
                    </a>
                </div>

            </div>

        </div>
    </div>

    @include('partials.footer')

@push('scripts')
<script>
    function copyRegNumber() {
        const regNum = document.getElementById('reg-number').innerText.trim();
        if (regNum && regNum !== '-') {
            navigator.clipboard.writeText(regNum).then(() => {
                const copyBtn = document.getElementById('copy-btn');
                const origContent = copyBtn.innerHTML;
                copyBtn.innerHTML = '<span class="material-symbols-outlined text-lg text-emerald-600">check</span>';
                copyBtn.classList.add('border-emerald-500', 'bg-emerald-50');
                
                if (window.showToast) {
                    window.showToast('Nomor pendaftaran berhasil disalin!', 'success');
                }
                
                setTimeout(() => {
                    copyBtn.innerHTML = origContent;
                    copyBtn.classList.remove('border-emerald-500', 'bg-emerald-50');
                }, 2000);
            }).catch(() => {
                if (window.showToast) {
                    window.showToast('Gagal menyalin nomor pendaftaran.', 'error');
                }
            });
        }
    }
</script>

<style>
    @keyframes popIn {
        0% { transform: scale(0.6) rotate(-8deg); opacity: 0; }
        50% { transform: scale(1.1) rotate(4deg); }
        100% { transform: scale(1) rotate(0); opacity: 1; }
    }
</style>
@endpush

@endsection
