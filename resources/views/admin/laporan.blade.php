{{-- resources/views/admin/laporan.blade.php --}}
@extends('layouts.admin')

@section('title', 'Laporan PPDB')

@section('content')

{{-- ── Page Header ──────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h2 class="text-3xl font-extrabold tracking-tight">Laporan PPDB</h2>
        <p class="text-slate-500 mt-1">Rekap dan ekspor data penerimaan siswa baru</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.laporan.export', ['format' => 'xlsx']) }}"
           class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity shadow-sm">
            <span class="material-symbols-outlined text-lg">table_view</span>
            Export Excel
        </a>
        <a href="{{ route('admin.laporan.export', ['format' => 'pdf']) }}"
           class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity shadow-sm">
            <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
            Export PDF
        </a>
    </div>
</div>

{{-- ── Summary Cards ─────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
    @php
        $summaryCards = [
            ['icon' => 'groups', 'label' => 'Total Pendaftar', 'value' => $stats['total'] ?? 0, 'color' => 'text-blue-600', 'bg' => 'bg-blue-50 dark:bg-blue-900/20'],
            ['icon' => 'check_circle', 'label' => 'Diterima', 'value' => $stats['diterima'] ?? 0, 'color' => 'text-green-600', 'bg' => 'bg-green-50 dark:bg-green-900/20'],
            ['icon' => 'cancel', 'label' => 'Ditolak', 'value' => $stats['ditolak'] ?? 0, 'color' => 'text-red-600', 'bg' => 'bg-red-50 dark:bg-red-900/20'],
            ['icon' => 'pending_actions', 'label' => 'Menunggu Verifikasi', 'value' => $stats['menunggu'] ?? 0, 'color' => 'text-orange-600', 'bg' => 'bg-orange-50 dark:bg-orange-900/20'],
        ];
    @endphp
    @foreach($summaryCards as $card)
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="size-12 rounded-xl {{ $card['bg'] }} flex items-center justify-center {{ $card['color'] }} mb-4">
                <span class="material-symbols-outlined text-2xl">{{ $card['icon'] }}</span>
            </div>
            <p class="text-slate-500 text-xs font-semibold">{{ $card['label'] }}</p>
            <h3 class="text-2xl font-extrabold mt-1">{{ number_format($card['value']) }}</h3>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    {{-- Rekap per Jurusan --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">school</span>
            <h4 class="font-bold">Rekap per Jurusan</h4>
        </div>
        <div class="p-8 space-y-5">
            @php
                $iconMap = ['TKJ' => 'router', 'AKL' => 'calculate', 'BDP' => 'storefront', 'MM' => 'movie_creation'];
                $total = max(array_sum(array_column($rekapJurusan ?? [], 'total')), 1);
            @endphp
            @forelse($rekapJurusan ?? [] as $r)
                @php
                    $pct = round(($r['total'] / $total) * 100);
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div
                                class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary text-sm">
                                <span class="material-symbols-outlined text-base">{{ $iconMap[$r['kode']] ?? 'school' }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold">{{ $r['nama'] }}</p>
                                <p class="text-[10px] text-slate-400">Kuota: {{ $r['kuota'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-extrabold">{{ $r['total'] }}</p>
                            <p class="text-[10px] text-slate-400">{{ $pct }}%</p>
                        </div>
                    </div>
                    <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full transition-all duration-500"
                            style="width: {{ $pct }}%"></div>
                    </div>
                    <div class="flex gap-3 mt-2">
                        @foreach([
                            ['key' => 'diterima', 'label' => 'Diterima', 'color' => 'text-green-600'],
                            ['key' => 'menunggu', 'label' => 'Menunggu', 'color' => 'text-orange-600'],
                            ['key' => 'ditolak', 'label' => 'Ditolak', 'color' => 'text-red-600'],
                        ] as $s)
                            <span class="text-[10px] font-semibold {{ $s['color'] }}">
                                {{ $s['label'] }}: {{ $r[$s['key']] ?? 0 }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-sm text-center py-6">Belum ada data</p>
            @endforelse
        </div>
    </div>

    {{-- Rekap per Status --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">donut_large</span>
            <h4 class="font-bold">Distribusi Status</h4>
        </div>
        <div class="p-8 space-y-4">
            @php
                $distribusi = [
                    ['label' => 'Diterima', 'value' => $stats['diterima'] ?? 0, 'color' => 'bg-green-500', 'text' => 'text-green-700'],
                    ['label' => 'Ditolak', 'value' => $stats['ditolak'] ?? 0, 'color' => 'bg-red-500', 'text' => 'text-red-700'],
                    ['label' => 'Menunggu Verifikasi', 'value' => $stats['menunggu'] ?? 0, 'color' => 'bg-orange-500', 'text' => 'text-orange-700'],
                    ['label' => 'Draft', 'value' => $stats['draft'] ?? 0, 'color' => 'bg-slate-300', 'text' => 'text-slate-600'],
                ];
                $grandTotal = max(array_sum(array_column($distribusi, 'value')), 1);
            @endphp
            @foreach($distribusi as $d)
                @php $dpct = round(($d['value'] / $grandTotal) * 100); @endphp
                <div class="flex items-center gap-4">
                    <div class="w-32 shrink-0">
                        <p class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ $d['label'] }}</p>
                    </div>
                    <div class="flex-1 h-2.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full {{ $d['color'] }} rounded-full" style="width: {{ $dpct }}%"></div>
                    </div>
                    <div class="w-16 text-right shrink-0">
                        <span class="text-sm font-extrabold {{ $d['text'] }}">{{ number_format($d['value']) }}</span>
                        <span class="text-[10px] text-slate-400 ml-1">{{ $dpct }}%</span>
                    </div>
                </div>
            @endforeach

            {{-- Donut visual sederhana --}}
            <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-center">
                <div class="relative size-32">
                    <svg viewBox="0 0 36 36" class="size-32 -rotate-90">
                        @php
                            $offset = 0;
                            $svgColors = ['#16a34a', '#dc2626', '#ea580c', '#94a3b8'];
                            $circumf = 2 * M_PI * 15.9;
                        @endphp
                        @foreach($distribusi as $idx => $d)
                            @php
                                $dashArray = round(($d['value'] / $grandTotal) * $circumf, 1);
                            @endphp
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="{{ $svgColors[$idx] }}"
                                stroke-width="3.5" stroke-dasharray="{{ $dashArray }} {{ $circumf }}"
                                stroke-dashoffset="{{ -$offset }}" stroke-linecap="round" />
                            @php $offset += $dashArray; @endphp
                        @endforeach
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <p class="text-xl font-extrabold">{{ number_format($grandTotal) }}</p>
                        <p class="text-[10px] text-slate-400">Total</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Tabel Lengkap (SESUAI PERMINTAAN) ─────────────────── --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
    <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold">Data Lengkap Pendaftar</h3>
            <p class="text-sm text-slate-500">Semua data untuk keperluan laporan</p>
        </div>
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex gap-2">
            <select name="status" class="px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-primary/20">
                <option value="">Semua Status</option>
                <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="menunggu_verifikasi" {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl text-xs font-bold hover:opacity-90 transition-opacity">
                Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50 text-[10px] uppercase tracking-wider font-bold text-slate-500">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Siswa</th>
                    <th class="px-6 py-4">No. Pendaftaran</th>
                    <th class="px-6 py-4">NISN</th>
                    <th class="px-6 py-4">Asal Sekolah</th>
                    <th class="px-6 py-4">Jurusan</th>
                    <th class="px-6 py-4">Tanggal Daftar</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($pendaftaran ?? [] as $i => $p)
                    @php
                        $nama = $p->siswa->nama_lengkap ?? $p->user->nama_lengkap ?? 'Tidak Diketahui';
                        $inisial = $nama !== 'Tidak Diketahui'
                            ? strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $nama), 0, 2))))
                            : '??';
                        
                        $statusBadge = [
                            'diterima' => 'bg-green-100 text-green-700',
                            'ditolak' => 'bg-red-100 text-red-700',
                            'menunggu_verifikasi' => 'bg-orange-100 text-orange-700',
                            'draft' => 'bg-slate-100 text-slate-600',
                        ];
                        $badge = $statusBadge[$p->status] ?? 'bg-slate-100 text-slate-600';
                    @endphp
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                        <td class="px-6 py-4 text-xs text-slate-400">{{ $pendaftaran->firstItem() + $i }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ $inisial }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold">{{ $nama }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $p->siswa->tempat_lahir ?? '—' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs font-mono font-medium text-slate-600 dark:text-slate-400">
                            {{ $p->nomor_pendaftaran }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-mono">
                            {{ $p->sekolahAsal->nisn ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 max-w-[200px] truncate">
                            {{ $p->sekolahAsal->nama_sekolah ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 rounded-full text-[10px] font-bold">
                                {{ $p->jurusan->kode_jurusan ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d/m/Y') : '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $badge }}">
                                {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-8 py-12 text-center text-slate-400 text-sm">
                            <span class="material-symbols-outlined text-4xl block mb-2">description</span>
                            Tidak ada data laporan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($pendaftaran) && $pendaftaran->hasPages())
        <div class="px-8 py-5 border-t border-slate-100 dark:border-slate-800">
            {{ $pendaftaran->withQueryString()->links() }}
        </div>
    @endif
</div>

@endsection