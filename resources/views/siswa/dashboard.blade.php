@extends('layouts.siswa')

@section('title', 'Dashboard Siswa - PPDB SMK NU II Medan')
@section('breadcrumb_parent', 'Siswa')
@section('breadcrumb', 'Dashboard')

@section('content')
    @php
        $user = auth()->user();
        $pendaftaran = $pendaftaran ?? null;

        $statusCfg = [
            'draft' => ['label' => 'Belum Selesai', 'bg' => '#F6CB04', 'color' => '#0f2318'],
            'menunggu_pembayaran' => ['label' => 'Menunggu Pembayaran', 'bg' => '#d97706', 'color' => '#fff'],
            'menunggu_verifikasi' => ['label' => 'Dalam Proses Verifikasi', 'bg' => '#F6CB04', 'color' => '#0f2318'],
            'terverifikasi' => ['label' => 'Berkas Terverifikasi', 'bg' => '#016b30', 'color' => '#fff'],
            'diterima' => ['label' => 'DITERIMA ✓', 'bg' => '#F6CB04', 'color' => '#0f2318'],
            'cadangan' => ['label' => 'Cadangan', 'bg' => '#7c3aed', 'color' => '#fff'],
            'ditolak' => ['label' => 'Tidak Diterima', 'bg' => '#dc2626', 'color' => '#fff'],
        ];
        $sc = $statusCfg[$pendaftaran?->status ?? 'draft'];

        $stepsDone = [
            'data_pribadi' => (bool) $pendaftaran?->siswa,
            'sekolah_asal' => (bool) $pendaftaran?->sekolahAsal,
            'orang_tua' => $pendaftaran?->orangTua && $pendaftaran->orangTua->isNotEmpty(),
            'jurusan' => (bool) $pendaftaran?->jurusan_id,
            'dokumen' => $pendaftaran?->dokumen && $pendaftaran->dokumen->isNotEmpty(),
        ];
        $stepsDoneCount = collect($stepsDone)->filter()->count();

        $finalStatus = ['diterima', 'cadangan', 'ditolak'];
        if (in_array($pendaftaran?->status, $finalStatus)) {
            $stepsDoneCount = 5;
            $progres = 100;
        } else {
            $progres = $stepsDoneCount > 0 ? round(($stepsDoneCount / 5) * 100) : 0;
        }

        $statusVerif = $pendaftaran?->status ?? 'draft';
        $isAccepted = $statusVerif === 'diterima';
        $isCadangan = $statusVerif === 'cadangan';
        $isRejected = $statusVerif === 'ditolak';
        $isTerverifikasi = $statusVerif === 'terverifikasi';
        $isMenunggu = $statusVerif === 'menunggu_verifikasi';
    @endphp

    <div class="space-y-6 lg:space-y-8 max-w-5xl w-full">

        {{-- Welcome Banner --}}
        <div class="rounded-2xl lg:rounded-3xl p-6 lg:p-8 text-white relative overflow-hidden"
            style="background-color:#018B3E; box-shadow:0 20px 60px rgba(1,139,62,0.2);">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 lg:gap-6">
                <div class="space-y-2 lg:space-y-3">
                    <h2 class="text-2xl lg:text-3xl xl:text-4xl font-black tracking-tight">
                        Halo, {{ $user->nama_lengkap }}! 👋
                    </h2>
                    <div class="flex items-center gap-2 text-white/80 text-xs lg:text-sm font-medium">
                        <span class="material-symbols-outlined text-base">today</span>
                        <span id="realtime-datetime"></span>
                    </div>
                    <div class="flex items-center gap-2 lg:gap-3 mt-2 lg:mt-4">
                        <span
                            class="px-3 lg:px-4 py-1.5 lg:py-2 rounded-full text-xs lg:text-sm font-bold flex items-center gap-2"
                            style="background-color:{{ $sc['bg'] }}; color:{{ $sc['color'] }};">
                            <span class="w-1.5 h-1.5 rounded-full animate-pulse"
                                style="background-color:{{ $sc['color'] }}; opacity:0.6;"></span>
                            {{ $sc['label'] }}
                        </span>
                    </div>
                </div>
                <div class="hidden lg:block opacity-20">
                    <span class="material-symbols-outlined" style="font-size:100px;">verified_user</span>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-32 lg:w-48 h-32 lg:h-48 rounded-full"
                style="background-color:rgba(255,255,255,0.1);"></div>
            <div class="absolute top-10 right-20 w-8 lg:w-12 h-8 lg:h-12 rounded-full"
                style="background-color:rgba(246,203,4,0.2);"></div>
        </div>

        {{-- Grid Progress + Sidebar --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            {{-- Progress --}}
            <div class="lg:col-span-2 bg-white rounded-2xl lg:rounded-3xl p-6 lg:p-8 shadow-sm"
                style="border:1px solid #f1f5f9;">
                <div class="flex items-center justify-between mb-6 lg:mb-8">
                    <h3 class="text-lg lg:text-xl font-bold text-slate-900">Progres Pendaftaran</h3>
                    <span class="font-bold text-sm px-3 py-1 rounded-full"
                        style="color:#018B3E; background-color:rgba(1,139,62,0.08);">
                        {{ $progres }}% Selesai
                    </span>
                </div>
                <div class="w-full h-2 bg-slate-100 rounded-full mb-8 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700"
                        style="width:{{ $progres }}%; background-color:#018B3E;"></div>
                </div>
                <div class="space-y-5 lg:space-y-6 relative">
                    <div class="absolute left-5 lg:left-6 top-2 bottom-2 w-0.5 bg-slate-100"></div>
                    @php
                        $steps = [
                            ['key' => 'data_pribadi', 'label' => 'Data Pribadi & Biodata', 'route' => 'siswa.pendaftaran.step1', 'done_sub' => 'Data diri telah diisi', 'pending_sub' => 'Isi data diri Anda'],
                            ['key' => 'sekolah_asal', 'label' => 'Data Sekolah Asal', 'route' => 'siswa.pendaftaran.step2', 'done_sub' => 'Data sekolah telah diisi', 'pending_sub' => 'Isi asal sekolah'],
                            ['key' => 'orang_tua', 'label' => 'Data Orang Tua / Wali', 'route' => 'siswa.pendaftaran.step3', 'done_sub' => 'Data orang tua telah diisi', 'pending_sub' => 'Isi data orang tua'],
                            ['key' => 'jurusan', 'label' => 'Pilih Jurusan', 'route' => 'siswa.pendaftaran.step4', 'done_sub' => 'Jurusan telah dipilih', 'pending_sub' => 'Pilih program keahlian'],
                            ['key' => 'dokumen', 'label' => 'Upload Dokumen', 'route' => 'siswa.pendaftaran.step5', 'done_sub' => 'Dokumen telah diunggah', 'pending_sub' => 'Upload berkas persyaratan'],
                        ];
                    @endphp
                    @foreach($steps as $idx => $step)
                        @php
                            $done = $stepsDone[$step['key']] ?? false;
                            $prevKey = $idx > 0 ? array_keys($stepsDone)[$idx - 1] : null;
                            $prevDone = $prevKey ? ($stepsDone[$prevKey] ?? false) : true;
                            $active = !$done && $prevDone;
                        @endphp
                        <div class="relative flex items-center gap-4 lg:gap-6">
                            <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-full flex items-center justify-center z-10 shrink-0 {{ $done ? 'text-white' : ($active ? 'animate-pulse' : '') }}"
                                style="{{ $done ? 'background-color:#018B3E;' : ($active ? 'background-color:rgba(1,139,62,0.1); color:#018B3E; border:2px solid rgba(1,139,62,0.3);' : 'background-color:#f1f5f9; color:#cbd5e1;') }}">
                                <span
                                    class="material-symbols-outlined text-sm lg:text-base">{{ $done ? 'check' : ($active ? 'pending' : 'lock') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-sm lg:text-base font-bold truncate {{ $done || $active ? 'text-slate-900' : 'text-slate-400' }}">
                                    {{ $step['label'] }}</p>
                                @if($done)
                                    <p class="text-xs text-green-600 font-medium">{{ $step['done_sub'] }}</p>
                                @elseif($active)
                                    <a href="{{ route($step['route']) }}"
                                        class="text-xs font-bold flex items-center gap-1 hover:underline" style="color:#018B3E;">
                                        Lanjutkan sekarang <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                    </a>
                                @else
                                    <p class="text-xs text-slate-400 italic">{{ $step['pending_sub'] }}</p>
                                @endif
                            </div>
                            <span
                                class="text-[10px] font-bold shrink-0 {{ $done ? 'text-green-600' : ($active ? 'text-[#018B3E]' : 'text-slate-300') }}">{{ $idx + 1 }}/5</span>
                        </div>
                    @endforeach

                    {{-- Step 6 Pengumuman --}}
                    <div class="relative flex items-center gap-4 lg:gap-6">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-full flex items-center justify-center z-10 shrink-0 {{ $isAccepted || $isCadangan || $isRejected || $isTerverifikasi ? 'text-white' : ($isMenunggu ? 'animate-pulse' : '') }}"
                            style="{{ $isAccepted ? 'background-color:#F6CB04; color:#0f2318;' : ($isCadangan ? 'background-color:#7c3aed;' : ($isRejected ? 'background-color:#dc2626;' : ($isTerverifikasi ? 'background-color:#018B3E;' : ($isMenunggu ? 'background-color:rgba(1,139,62,0.1); color:#018B3E; border:2px solid rgba(1,139,62,0.3);' : 'background-color:#f1f5f9; color:#cbd5e1;')))) }}">
                            <span class="material-symbols-outlined text-sm lg:text-base">
                                {{ $isAccepted ? 'emoji_events' : ($isCadangan ? 'bookmark' : ($isRejected ? 'cancel' : ($isTerverifikasi ? 'verified' : ($isMenunggu ? 'pending' : 'lock')))) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p
                                class="text-sm lg:text-base font-bold truncate {{ $isAccepted || $isCadangan || $isRejected || $isTerverifikasi || $isMenunggu ? 'text-slate-900' : 'text-slate-400' }}">
                                Pengumuman Kelulusan</p>
                            <p
                                class="text-xs {{ $isAccepted ? 'text-green-600 font-bold' : ($isCadangan ? 'text-purple-600 font-bold' : ($isRejected ? 'text-red-500 font-bold' : ($isTerverifikasi ? 'text-slate-500 italic' : ($isMenunggu ? 'text-orange-500 italic' : 'text-slate-400 italic')))) }}">
                                @if($isAccepted) 🎉 Selamat! Anda diterima
                                @elseif($isCadangan) 📌 Anda masuk daftar cadangan
                                @elseif($isRejected) 😔 Mohon maaf, tidak diterima
                                @elseif($isTerverifikasi) ⏳ Menunggu keputusan final
                                @elseif($isMenunggu) 🔍 Menunggu verifikasi panitia
                                @else 🔒 Menunggu tahap sebelumnya
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="flex flex-col gap-6 lg:gap-8">

                {{-- Pengumuman --}}
                <div class="bg-white rounded-2xl lg:rounded-3xl p-5 lg:p-6 shadow-sm" style="border:1px solid #f1f5f9;">
                    <div class="flex items-center gap-2 mb-4 lg:mb-5">
                        <span class="material-symbols-outlined text-lg" style="color:#018B3E;">campaign</span>
                        <h3 class="text-base font-bold text-slate-900">Pengumuman</h3>
                    </div>
                    @if(isset($pengumuman) && $pengumuman->count() > 0)
                        <div class="space-y-3">
                            @foreach($pengumuman->take(3) as $p)
                                @php $tgl = $p->tanggal_publish ?? $p->created_at;
                                $isNew = \Carbon\Carbon::parse($tgl)->diffInDays(now()) < 7; @endphp
                                <a href="{{ route('pengumuman.publik') }}"
                                    class="block p-3 lg:p-4 rounded-xl transition-all hover:scale-[1.01]"
                                    style="background-color:rgba(1,139,62,0.05); border-left:3px solid #018B3E;">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-xs font-bold text-slate-800 leading-snug line-clamp-2">{{ $p->judul }}</p>
                                        @if($isNew)<span class="shrink-0 text-[9px] font-black px-1.5 py-0.5 rounded-full"
                                        style="background-color:#F6CB04; color:#0f2318;">BARU</span>@endif
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1.5">
                                        {{ \Carbon\Carbon::parse($tgl)->translatedFormat('d M Y') }}</p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="py-6 text-center">
                            <span class="material-symbols-outlined text-3xl text-slate-200 block mb-2">campaign</span>
                            <p class="text-xs text-slate-400 font-medium">Belum ada pengumuman</p>
                        </div>
                    @endif
                    <a href="{{ route('pengumuman.publik') }}"
                        class="block w-full mt-4 py-2 font-bold text-xs text-center flex items-center justify-center gap-1"
                        style="color:#018B3E;">
                        Lihat Semua <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </a>
                </div>

                {{-- Periode PPDB --}}
                @if($ppdb ?? false)
                    <div class="bg-white rounded-2xl p-5 shadow-sm" style="border:1px solid #f1f5f9;">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="material-symbols-outlined text-base" style="color:#018B3E;">calendar_month</span>
                            <p class="text-sm font-bold text-slate-800">Periode PPDB</p>
                        </div>
                        <p class="text-xs font-bold text-slate-600">{{ $ppdb->tahun_ajaran }}</p>
                        <div class="mt-2 space-y-1.5">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400">Tutup</span>
                                <span class="font-semibold text-slate-700">{{ $ppdb->tanggal_tutup->format('d M Y') }}</span>
                            </div>
                            @if($ppdb->tanggal_pengumuman)
                                <div class="flex justify-between text-xs">
                                    <span class="text-slate-400">Pengumuman</span>
                                    <span
                                        class="font-semibold text-slate-700">{{ $ppdb->tanggal_pengumuman->format('d M Y') }}</span>
                                </div>
                            @endif
                        </div>
                        @php $sisaHari = floor(now()->diffInDays($ppdb->tanggal_tutup, false)); @endphp
                        @if($sisaHari > 0)
                            <div class="mt-3 pt-3 border-t border-slate-100 text-center">
                                <span class="text-2xl font-black" style="color:#018B3E;">{{ $sisaHari }}</span>
                                <span class="text-xs text-slate-400 ml-1">hari lagi</span>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Help --}}
                <div class="rounded-2xl lg:rounded-3xl p-5 lg:p-6 text-white overflow-hidden relative"
                    style="background-color:#0f2318;">
                    <div class="relative z-10">
                        <h4 class="text-base font-bold mb-2">Butuh Bantuan?</h4>
                        <p class="text-xs text-slate-300 mb-4">Hubungi panitia PPDB melalui WhatsApp resmi kami.</p>
                        @php $pesan = "Halo admin PPDB SMK NU II Medan, saya " . auth()->user()->nama_lengkap . " ingin bertanya mengenai pendaftaran. Terima kasih."; @endphp
                        <a href="https://wa.me/6281266857686?text={{ urlencode($pesan) }}" target="_blank"
                            class="inline-flex items-center gap-2 text-white font-bold py-2.5 px-5 rounded-xl w-full justify-center text-sm bg-green-600 hover:bg-green-700 transition-all">
                            <span class="material-symbols-outlined text-base">chat</span> Chat Panitia
                        </a>
                    </div>
                    <div class="absolute inset-0 opacity-10"
                        style="background:radial-gradient(circle at top right, #018B3E, transparent);"></div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateDatetime() {
            const el = document.getElementById('realtime-datetime');
            if (!el) return;
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            el.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}  ·  ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}:${String(now.getSeconds()).padStart(2, '0')} WIB`;
        }
        updateDatetime();
        setInterval(updateDatetime, 1000);
    </script>
@endpush