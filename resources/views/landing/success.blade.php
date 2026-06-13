@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - SMK NU II Medan')

@section('content')
    @include('partials.navbar')

    <div class="min-h-screen py-16 bg-background-light">

        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success Card --}}
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

                {{-- Top Banner --}}
                <div class="px-8 py-10 text-center bg-gradient-to-br from-primary to-[#025c2a]">
                    {{-- Animated Check Icon --}}
                    <div class="size-24 rounded-full mx-auto flex items-center justify-center mb-5"
                         style="background-color: rgba(246,203,4,0.15); box-shadow: 0 0 0 16px rgba(246,203,4,0.08);">
                        <span class="material-symbols-outlined text-5xl text-secondary" style="animation: bounceIn 0.6s ease-out;">
                            check_circle
                        </span>
                    </div>

                    <h1 class="text-3xl font-black text-white mb-2">Pendaftaran Berhasil!</h1>
                    <p class="text-base font-medium" style="color: rgba(246,203,4,0.9);">
                        Formulir PPDB SMK NU II Medan telah kami terima
                    </p>
                </div>

                {{-- Body Content --}}
                <div class="px-8 py-8 space-y-6">

                    {{-- Nomor Pendaftaran Highlight --}}
                    <div class="rounded-2xl p-6 text-center border-2"
                         style="border-color: rgba(1,139,62,0.25); background-color: rgba(1,139,62,0.04);">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Nomor Pendaftaran Anda</p>
                        <p class="text-3xl font-black tracking-widest font-mono text-primary">
                            {{ $pendaftaran->nomor_pendaftaran ?? '-' }}
                        </p>
                        <p class="text-xs text-slate-400 mt-2">Simpan nomor ini untuk keperluan verifikasi</p>
                    </div>

                    {{-- Student Info --}}
                    <div class="rounded-2xl p-5 bg-slate-50 border border-slate-200 space-y-3">
                        @php $nama = $pendaftaran->siswa->nama_lengkap ?? $pendaftaran->nama_lengkap ?? '-'; @endphp

                        <div class="flex items-center gap-3">
                            <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary text-lg">person</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Pendaftar</p>
                                <p class="text-sm font-bold text-slate-800">{{ $nama }}</p>
                            </div>
                        </div>

                        @if($pendaftaran->jurusan)
                        <div class="flex items-center gap-3">
                            <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary text-lg">school</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Jurusan Pilihan Utama</p>
                                <p class="text-sm font-bold text-slate-800">{{ $pendaftaran->jurusan->nama_jurusan }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center gap-3">
                            <div class="size-9 rounded-full bg-orange-50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-orange-500 text-lg">hourglass_empty</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</p>
                                <p class="text-sm font-bold text-orange-600">Menunggu Verifikasi Admin</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="size-9 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-slate-500 text-lg">calendar_today</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tanggal Daftar</p>
                                <p class="text-sm font-bold text-slate-800">
                                    {{ $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->translatedFormat('d M Y, H:i') . ' WIB' : now()->translatedFormat('d M Y, H:i') . ' WIB' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- What's Next Section --}}
                    <div class="space-y-3">
                        <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-700">Langkah Selanjutnya</h3>
                        @php
                            $steps = [
                                ['icon' => 'save', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50', 'title' => 'Simpan Nomor Pendaftaran', 'desc' => 'Catat atau screenshot nomor pendaftaran Anda sebagai bukti registrasi.'],
                                ['icon' => 'pending_actions', 'color' => 'text-orange-600', 'bg' => 'bg-orange-50', 'title' => 'Tunggu Verifikasi Admin', 'desc' => 'Tim admin akan memverifikasi berkas yang Anda upload dalam 1-3 hari kerja.'],
                                ['icon' => 'campaign', 'color' => 'text-green-600', 'bg' => 'bg-green-50', 'title' => 'Cek Pengumuman', 'desc' => 'Pantau halaman pengumuman untuk mengetahui hasil seleksi PPDB Anda.'],
                            ];
                        @endphp
                        @foreach($steps as $i => $s)
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="size-9 rounded-xl {{ $s['bg'] }} flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-lg {{ $s['color'] }}">{{ $s['icon'] }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $i + 1 }}. {{ $s['title'] }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $s['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Contact Info --}}
                    <div class="rounded-xl p-4 border" style="border-color: rgba(1,139,62,0.2); background-color: rgba(1,139,62,0.04);">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="material-symbols-outlined text-primary text-base">info</span>
                            <p class="text-xs font-bold text-slate-700">Butuh Bantuan?</p>
                        </div>
                        <p class="text-xs text-slate-500">
                            Hubungi kami melalui WhatsApp atau datang langsung ke SMK NU II Medan untuk informasi lebih lanjut mengenai pendaftaran Anda.
                        </p>
                    </div>

                </div>

                {{-- Footer Actions --}}
                <div class="px-8 pb-8 flex flex-col lg:flex-row gap-3">
                    <a href="{{ route('landing.pendaftaran.cetak', $pendaftaran->id) }}"
                       class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm text-background-dark transition-all shadow-md bg-secondary"
                       onmouseover="this.style.filter='brightness(1.1)';"
                       onmouseout="this.style.filter='none';">
                        <span class="material-symbols-outlined text-lg">download</span>
                        Unduh Kartu Pendaftaran
                    </a>
                    <a href="{{ route('pengumuman.publik') }}"
                       class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm border-2 transition-all border-primary text-primary"
                       onmouseover="this.style.backgroundColor='rgba(1,139,62,0.06)';"
                       onmouseout="this.style.backgroundColor='transparent';">
                        <span class="material-symbols-outlined text-lg">campaign</span>
                        Lihat Pengumuman
                    </a>
                    <a href="{{ route('home') }}"
                       class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm text-white transition-all bg-primary"
                       style="box-shadow: 0 4px 16px rgba(1,139,62,0.3);"
                       onmouseover="this.style.opacity='0.9';"
                       onmouseout="this.style.opacity='1';">
                        <span class="material-symbols-outlined text-lg">home</span>
                        Ke Beranda
                    </a>
                </div>

            </div>

        </div>
    </div>

    @include('partials.footer')

@push('scripts')
<style>
    @keyframes bounceIn {
        0% { transform: scale(0.3); opacity: 0; }
        50% { transform: scale(1.1); opacity: 0.9; }
        70% { transform: scale(0.95); }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
@endpush

@endsection
