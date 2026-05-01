@extends('layouts.siswa')

@section('title', 'Pendaftaran - PPDB SMK NU II Medan')
@section('breadcrumb_parent', 'Siswa')
@section('breadcrumb', 'Pendaftaran')

@section('content')
<div class="space-y-6 lg:space-y-8 max-w-7xl w-full">

    
    {{-- ── Heading ──────────────────────────────────────────────── --}}
    <div class="text-center px-2">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 mb-2">Pilih Periode Pendaftaran</h1>
        <p class="text-xs sm:text-sm lg:text-base text-slate-500 px-2">Pilih periode pendaftaran yang tersedia untuk memulai proses PPDB</p>
    </div>
    {{-- ── Info Penting (paling atas) ─────────────────────────── --}}
    <div class="p-4 sm:p-5 rounded-2xl border flex items-start gap-3 sm:gap-4"
        style="background-color:rgba(1,139,62,0.06); border-color:rgba(1,139,62,0.2);">
        <div class="size-8 sm:size-9 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
            style="background-color:rgba(1,139,62,0.12);">
            <span class="material-symbols-outlined text-base sm:text-lg" style="color:#018B3E;">info</span>
        </div>
        <div>
            <p class="text-xs sm:text-sm font-bold mb-1.5" style="color:#018B3E;">Informasi Penting</p>
            <ul class="space-y-1">
                @foreach([
                    'Pilih periode pendaftaran yang sesuai dengan gelombang yang Anda inginkan.',
                    'Setelah memilih periode, Anda akan diarahkan ke formulir pendaftaran.',
                    'Pastikan memilih periode sebelum tanggal tutup pendaftaran.',
                ] as $info)
                <li class="flex items-start gap-2 text-[11px] sm:text-xs text-slate-600">
                    <span class="material-symbols-outlined text-xs shrink-0 mt-0.5" style="color:#018B3E;">check_small</span>
                    {{ $info }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>


    {{-- ── Tab Filter ───────────────────────────────────────────── --}}
    <div class="flex justify-center overflow-x-auto pb-2">
        <div class="inline-flex p-1 bg-white rounded-xl shadow-sm border border-slate-200 min-w-max">
            @foreach([
                ['val'=>'semua',       'label'=>'Semua ('.$periodeTersedia->count().')'],
                ['val'=>'berlangsung', 'label'=>'Sedang Berlangsung'],
                ['val'=>'berakhir',    'label'=>'Telah Berakhir'],
            ] as $tab)
            <button onclick="filterPeriode('{{ $tab['val'] }}')"
                class="filter-btn px-3 sm:px-6 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold rounded-lg transition-all whitespace-nowrap"
                data-filter="{{ $tab['val'] }}"
                style="{{ $tab['val'] === 'semua' ? 'background-color:#018B3E; color:white;' : 'color:#64748b;' }}">
                {{ $tab['label'] }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- ── Daftar Periode ───────────────────────────────────────── --}}
    @if($periodeTersedia->isEmpty())
    <div class="bg-white rounded-xl sm:rounded-2xl p-6 sm:p-8 lg:p-12 text-center border border-slate-200">
        <div class="size-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
            style="background-color:rgba(1,139,62,0.08);">
            <span class="material-symbols-outlined text-3xl" style="color:#018B3E;">event_busy</span>
        </div>
        <h3 class="text-lg sm:text-xl font-bold text-slate-700 mb-2">Tidak Ada Periode Aktif</h3>
        <p class="text-xs sm:text-sm text-slate-500">Saat ini belum ada periode pendaftaran yang tersedia.</p>
    </div>
    @else
    @php
        $sortedPeriode = $periodeTersedia->sortByDesc(function($item) {
            if ($item->tanggal_buka <= now() && $item->tanggal_tutup >= now()) return 3;
            if ($item->tanggal_buka > now()) return 2;
            return 1;
        });
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">
        @foreach($sortedPeriode as $periode)
        @php
            $status = $periode->tanggal_tutup < now() ? 'berakhir' : ($periode->tanggal_buka > now() ? 'akan_datang' : 'berlangsung');
            $sc = [
                'berlangsung' => ['bg'=>'bg-[#018B3E]/10','border'=>'border-[#018B3E]/20','text'=>'text-[#018B3E]','lightBg'=>'bg-[#018B3E]/5'],
                'akan_datang' => ['bg'=>'bg-blue-50','border'=>'border-blue-200','text'=>'text-blue-700','lightBg'=>'bg-blue-50/50'],
                'berakhir'    => ['bg'=>'bg-slate-100','border'=>'border-slate-200','text'=>'text-slate-500','lightBg'=>'bg-slate-50'],
            ][$status];
        @endphp
        <div class="periode-card bg-white rounded-xl sm:rounded-2xl p-4 sm:p-5 lg:p-6 border border-slate-200 hover:shadow-lg transition-all
            {{ $status == 'berlangsung' ? 'ring-2 ring-[#018B3E]/20' : ($status == 'berakhir' ? 'opacity-70' : '') }}"
            data-status="{{ $status }}"
            style="{{ $status == 'berlangsung' ? 'border-color:#018B3E;' : '' }}">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl {{ $sc['bg'] }} flex items-center justify-center {{ $sc['text'] }} shrink-0">
                        <span class="material-symbols-outlined text-xl sm:text-2xl">event</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-bold text-base sm:text-lg text-slate-900 truncate">{{ $periode->tahun_ajaran }}</h3>
                        <p class="text-[10px] sm:text-xs text-slate-500">Periode Pendaftaran</p>
                    </div>
                </div>
                <!-- <span class="px-2 sm:px-3 py-1 text-[10px] sm:text-xs font-semibold rounded-full {{ $sc['bg'] }} {{ $sc['text'] }} border {{ $sc['border'] }} w-fit">
                    {{ $status == 'berlangsung' ? 'Sedang Berlangsung' : ($status == 'akan_datang' ? 'Akan Datang' : 'Telah Berakhir') }}
                </span> -->
            </div>

            @if($status == 'berlangsung')
            @php
                $totalHari    = $periode->tanggal_buka->diffInDays($periode->tanggal_tutup);
                $hariTerlewat = $periode->tanggal_buka->diffInDays(now());
                $persentase   = min(100, ($hariTerlewat / max($totalHari, 1)) * 100);
            @endphp
            <!-- <div class="mb-4">
                <div class="flex items-center justify-between text-[10px] sm:text-xs mb-1">
                    <span class="text-slate-500">Progress</span>
                    <span class="font-semibold" style="color:#018B3E;">{{ round($persentase) }}%</span>
                </div>
                <div class="w-full h-1.5 sm:h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full" style="background-color:#018B3E; width:{{ $persentase }}%"></div>
                </div>
            </div> -->
            @endif

            <div class="grid grid-cols-2 gap-2 sm:gap-3 mb-4">
                <div class="p-2 sm:p-3 {{ $sc['lightBg'] }} rounded-xl">
                    <span class="material-symbols-outlined text-xs sm:text-sm" style="color:#018B3E;">event_available</span>
                    <p class="text-[10px] sm:text-xs text-slate-500 mt-1">Buka</p>
                    <p class="text-xs sm:text-sm font-semibold truncate">{{ $periode->tanggal_buka->format('d/m/Y') }}</p>
                </div>
                <div class="p-2 sm:p-3 {{ $sc['lightBg'] }} rounded-xl">
                    <span class="material-symbols-outlined text-xs sm:text-sm" style="color:#018B3E;">event_busy</span>
                    <p class="text-[10px] sm:text-xs text-slate-500 mt-1">Tutup</p>
                    <p class="text-xs sm:text-sm font-semibold truncate">{{ $periode->tanggal_tutup->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="space-y-1.5 sm:space-y-2 mb-4">
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <span class="material-symbols-outlined text-[10px] sm:text-xs shrink-0" style="color:#018B3E;">payments</span>
                    <span class="text-slate-600 text-[10px] sm:text-xs">
                        Biaya: <span class="font-semibold {{ $periode->biaya_pendaftaran == 0 ? 'text-[#018B3E]' : 'text-slate-700' }}">
                            {{ $periode->biaya_pendaftaran > 0 ? 'Rp '.number_format($periode->biaya_pendaftaran,0,',','.') : 'Gratis' }}
                        </span>
                    </span>
                </div>
            </div>

            @if($status == 'berlangsung')
            @php $sisaHari = now()->diffInDays($periode->tanggal_tutup, false); @endphp
            <div class="mb-4 p-2 sm:p-3 {{ $sc['lightBg'] }} rounded-xl">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-xs font-semibold" style="color:#018B3E;">Sisa waktu:</span>
                    <span class="text-xs sm:text-sm font-bold" style="color:#018B3E;">{{ floor($sisaHari) }} hari</span>
                </div>
            </div>

            @php
                $sudahDaftar = isset($pendaftaran) && $pendaftaran
                    && $pendaftaran->pengaturan_ppdb_id == $periode->id;
            @endphp

            @if($sudahDaftar)
            <a href="{{ route('siswa.pendaftaran.riwayat') }}"
                class="w-full py-2.5 sm:py-3 font-bold rounded-xl flex items-center justify-center gap-2 text-xs sm:text-sm transition-all"
                style="background-color:#F6CB04; color:#0f2318;">
                <span class="material-symbols-outlined text-base sm:text-lg">check_circle</span>
                Berhasil Mendaftar
            </a>
            @else
            <form method="POST" action="{{ route('siswa.pendaftaran.pilih-periode') }}">
                @csrf
                <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                <button type="submit"
                    class="w-full py-2.5 sm:py-3 text-white font-bold rounded-xl hover:opacity-90 transition-all flex items-center justify-center gap-2 text-xs sm:text-sm"
                    style="background-color:#018B3E;">
                    <span class="material-symbols-outlined text-base sm:text-lg">how_to_reg</span>
                    Pilih Periode Ini
                </button>
            </form>
            @endif
            @else
            <button disabled
                class="w-full py-2.5 sm:py-3 bg-slate-100 text-slate-400 font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2 text-xs sm:text-sm">
                <span class="material-symbols-outlined text-base sm:text-lg">block</span>
                {{ $status == 'akan_datang' ? 'Belum Dibuka' : 'Periode Berakhir' }}
            </button>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- ── Bantuan ───────────────────────────────────────────────── --}}
    <div class="flex flex-col items-center gap-3 text-center pt-4 lg:pt-6">
        <p class="text-xs lg:text-sm text-slate-500">Butuh bantuan pengisian? Hubungi Panitia PPDB</p>
        @php $pesan = "Halo admin PPDB SMK NU II Medan, saya " . auth()->user()->nama_lengkap . " ingin bertanya. Terima kasih."; @endphp
        <a href="https://wa.me/6281266857686?text={{ urlencode($pesan) }}" target="_blank"
            class="flex items-center justify-center gap-2 font-bold text-xs lg:text-sm px-5 py-2.5 rounded-full border transition-all"
            style="color:#018B3E; background-color:rgba(1,139,62,0.05); border-color:rgba(1,139,62,0.15);"
            onmouseover="this.style.backgroundColor='rgba(1,139,62,0.1)';"
            onmouseout="this.style.backgroundColor='rgba(1,139,62,0.05)';">
            <span class="material-symbols-outlined text-sm lg:text-base">support_agent</span>
            WhatsApp Center
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
function filterPeriode(status) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.style.backgroundColor = '';
        btn.style.color = '#64748b';
    });
    const activeBtn = document.querySelector(`.filter-btn[data-filter="${status}"]`);
    if (activeBtn) { activeBtn.style.backgroundColor = '#018B3E'; activeBtn.style.color = 'white'; }
    document.querySelectorAll('.periode-card').forEach(card => {
        card.style.display = (status === 'semua' || card.dataset.status === status) ? 'block' : 'none';
    });
}
</script>
@endpush