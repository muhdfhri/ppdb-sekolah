{{-- resources/views/admin/pengaturan/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Periode PPDB')

@section('content')

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Periode PPDB</h2>
            <p class="text-slate-500 mt-1">Kelola periode pendaftaran dan kuota jurusan</p>
        </div>
        <a href="{{ route('admin.pengaturan.periode.create') }}"
            class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition-all">
            <span class="material-symbols-outlined text-lg">add</span>
            Tambah Periode Baru
        </a>
    </div>

    {{-- Info Box --}}
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3">
        <span class="material-symbols-outlined text-blue-600 text-sm shrink-0 mt-0.5">info</span>
        <div class="text-xs text-blue-800">
            <p class="font-semibold mb-1">Informasi Periode Aktif:</p>
            <p>Sistem mendukung <span class="font-bold">beberapa periode aktif</span> sekaligus. Anda dapat mengaktifkan
                lebih dari satu periode (misal: gelombang 1, gelombang 2). Siswa dapat memilih periode saat mendaftar.</p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        @php
            $totalPeriode   = App\Models\PengaturanPpdb::count();
            $totalAktif     = App\Models\PengaturanPpdb::where('is_active', true)->count();
            $totalPendaftar = App\Models\Pendaftaran::count();
        @endphp
        @foreach([
            ['icon' => 'calendar_month', 'color' => 'blue',   'value' => $totalPeriode,   'label' => 'Total Periode'],
            ['icon' => 'check_circle',   'color' => 'green',  'value' => $totalAktif,     'label' => 'Periode Aktif'],
            ['icon' => 'groups',         'color' => 'purple', 'value' => $totalPendaftar, 'label' => 'Total Pendaftar'],
        ] as $s)
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-{{ $s['color'] }}-50 flex items-center justify-center text-{{ $s['color'] }}-600">
                    <span class="material-symbols-outlined">{{ $s['icon'] }}</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $s['value'] }}</p>
                    <p class="text-xs text-slate-500">{{ $s['label'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Tabel Periode PPDB ──────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
            <h3 class="font-bold">Daftar Periode PPDB</h3>
            <span class="text-xs text-slate-500">Total: {{ $periode->total() }} periode</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[10px] uppercase tracking-wider font-bold text-slate-500">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Tahun Ajaran</th>
                        <th class="px-6 py-4">Tanggal Buka</th>
                        <th class="px-6 py-4">Tanggal Tutup</th>
                        <th class="px-6 py-4">Pengumuman</th>
                        <th class="px-6 py-4">Biaya</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($periode as $i => $p)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-400">{{ $periode->firstItem() + $i }}</td>
                            <td class="px-6 py-4 font-semibold">{{ $p->tahun_ajaran }}</td>
                            <td class="px-6 py-4 text-sm">{{ $p->tanggal_buka->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">{{ $p->tanggal_tutup->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">{{ $p->tanggal_pengumuman ? $p->tanggal_pengumuman->format('d/m/Y') : '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                {{ $p->biaya_pendaftaran > 0 ? 'Rp ' . number_format($p->biaya_pendaftaran, 0, ',', '.') : 'Gratis' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($p->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold">
                                        <span class="size-1.5 bg-green-500 rounded-full"></span>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold">
                                        <span class="size-1.5 bg-slate-400 rounded-full"></span>Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.pengaturan.periode.show', $p->id) }}"
                                        class="p-1.5 text-slate-400 hover:text-primary transition-colors rounded-lg hover:bg-primary/5"
                                        title="Lihat Detail">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                    <a href="{{ route('admin.pengaturan.periode.edit', $p->id) }}"
                                        class="p-1.5 text-slate-400 hover:text-blue-600 transition-colors rounded-lg hover:bg-blue-50"
                                        title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>

                                    {{-- Toggle Active --}}
                                    <form method="POST" action="{{ route('admin.pengaturan.periode.toggle', $p->id) }}" class="inline">
                                        @csrf @method('PATCH')
                                        @if($p->is_active)
                                            <button type="submit"
                                                class="p-1.5 text-slate-400 hover:text-orange-600 transition-colors rounded-lg hover:bg-orange-50"
                                                title="Nonaktifkan"
                                                onclick="return confirm('Nonaktifkan periode ini?')">
                                                <span class="material-symbols-outlined text-lg">toggle_off</span>
                                            </button>
                                        @else
                                            <button type="submit"
                                                class="p-1.5 text-slate-400 hover:text-green-600 transition-colors rounded-lg hover:bg-green-50"
                                                title="Aktifkan"
                                                onclick="return confirm('Aktifkan periode ini?')">
                                                <span class="material-symbols-outlined text-lg">toggle_on</span>
                                            </button>
                                        @endif
                                    </form>

                                    {{-- Hapus periode (pakai modal) --}}
                                    <button
                                        onclick="confirmDeletePeriode({{ $p->id }}, '{{ addslashes($p->tahun_ajaran) }}')"
                                        class="p-1.5 text-slate-400 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50"
                                        title="Hapus">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                    <form id="delete-periode-form-{{ $p->id }}"
                                          action="{{ route('admin.pengaturan.periode.destroy', $p->id) }}"
                                          method="POST" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl block mb-2">event_busy</span>
                                Belum ada periode PPDB
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($periode->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">{{ $periode->links() }}</div>
        @endif
    </div>

    {{-- ── Manajemen Jurusan ───────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">schema</span>
                <h3 class="font-bold">Manajemen Jurusan</h3>
            </div>
            <a href="{{ route('admin.jurusan.create') }}"
                class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                Tambah Jurusan Baru
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] uppercase tracking-wider font-bold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Nama Jurusan</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Kuota</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jurusan as $j)
                        @php
                            $iconMap = ['TKJ' => 'router', 'AKL' => 'calculate', 'BDP' => 'storefront', 'MM' => 'movie_creation'];
                            $icon    = $iconMap[$j->kode_jurusan] ?? 'school';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-bold text-primary">{{ $j->kode_jurusan }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-sm">{{ $icon }}</span>
                                    </div>
                                    <span class="font-semibold">{{ $j->nama_jurusan }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">{{ $j->deskripsi ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-primary">{{ $j->kuota }}</span>
                                <span class="text-xs text-slate-400 ml-1">siswa</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($j->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold">
                                        <span class="size-1.5 bg-green-500 rounded-full"></span>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold">
                                        <span class="size-1.5 bg-slate-400 rounded-full"></span>Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.jurusan.edit', $j->id) }}"
                                        class="p-1.5 text-slate-400 hover:text-blue-600 transition-colors rounded-lg hover:bg-blue-50"
                                        title="Edit Jurusan">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>

                                    {{-- Toggle Active --}}
                                    <form method="POST" action="{{ route('admin.jurusan.toggle', $j->id) }}" class="inline">
                                        @csrf @method('PATCH')
                                        @if($j->is_active)
                                            <button type="submit"
                                                class="p-1.5 text-slate-400 hover:text-orange-600 transition-colors rounded-lg hover:bg-orange-50"
                                                title="Nonaktifkan">
                                                <span class="material-symbols-outlined text-lg">toggle_off</span>
                                            </button>
                                        @else
                                            <button type="submit"
                                                class="p-1.5 text-slate-400 hover:text-green-600 transition-colors rounded-lg hover:bg-green-50"
                                                title="Aktifkan">
                                                <span class="material-symbols-outlined text-lg">toggle_on</span>
                                            </button>
                                        @endif
                                    </form>

                                    {{-- Hapus jurusan (pakai modal) --}}
                                    <button
                                        onclick="confirmDeleteJurusan({{ $j->id }}, '{{ addslashes($j->nama_jurusan) }}')"
                                        class="p-1.5 text-slate-400 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50"
                                        title="Hapus Jurusan">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                    <form id="delete-jurusan-form-{{ $j->id }}"
                                          action="{{ route('admin.jurusan.destroy', $j->id) }}"
                                          method="POST" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl block mb-2">school</span>
                                <p class="font-semibold">Belum ada jurusan</p>
                                <p class="text-sm mt-1">Klik tombol "Tambah Jurusan Baru" untuk menambahkan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Inject modal ke <body> agar tidak terkena overflow:hidden layout ──
    const modalHTML = `
    <div id="modal-delete-overlay"
        style="display:none; position:fixed; inset:0; width:100vw; height:100vh;
               background:rgba(0,0,0,0.6); backdrop-filter:blur(3px);
               z-index:99999; align-items:center; justify-content:center; padding:1rem;">
        <div style="background:white; border-radius:1.25rem;
                    box-shadow:0 25px 60px rgba(0,0,0,0.25);
                    width:100%; max-width:380px; padding:2rem;">

            {{-- Icon --}}
            <div style="width:56px; height:56px; border-radius:50%;
                        background:rgba(239,68,68,0.1); display:flex;
                        align-items:center; justify-content:center; margin:0 auto 1rem;">
                <span class="material-symbols-outlined" style="font-size:28px; color:#ef4444;">delete_forever</span>
            </div>

            {{-- Judul --}}
            <h3 id="modal-title"
                style="text-align:center; font-weight:800; font-size:1.1rem;
                       color:#0f172a; margin:0 0 0.5rem;">
                Hapus Data?
            </h3>

            {{-- Deskripsi --}}
            <p style="text-align:center; color:#64748b; font-size:0.875rem; margin:0 0 0.25rem;">
                <span id="modal-type-label" style="font-size:0.75rem; font-weight:600;
                    color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em;
                    display:block; margin-bottom:0.5rem;"></span>
                "<span id="modal-item-name" style="font-weight:700; color:#334155;"></span>"
                akan dihapus secara permanen.
            </p>
            <p style="text-align:center; color:#94a3b8; font-size:0.75rem; margin:0 0 1.5rem;">
                Tindakan ini <strong style="color:#ef4444;">tidak dapat dibatalkan</strong>.
            </p>

            {{-- Buttons --}}
            <div style="display:flex; gap:0.75rem;">
                <button id="modal-btn-batal"
                    style="flex:1; padding:0.75rem; border-radius:0.75rem; font-weight:700;
                           font-size:0.875rem; color:#475569; background:#f1f5f9;
                           border:none; cursor:pointer; transition:background 0.15s;"
                    onmouseover="this.style.background='#e2e8f0';"
                    onmouseout="this.style.background='#f1f5f9';">
                    Batal
                </button>
                <button id="modal-btn-hapus"
                    style="flex:1; padding:0.75rem; border-radius:0.75rem; font-weight:700;
                           font-size:0.875rem; color:white; background:#ef4444;
                           border:none; cursor:pointer; transition:background 0.15s;
                           display:flex; align-items:center; justify-content:center; gap:0.4rem;"
                    onmouseover="this.style.background='#dc2626';"
                    onmouseout="this.style.background='#ef4444';">
                    <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>`;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Event listeners
    document.getElementById('modal-btn-batal').addEventListener('click', closeDeleteModal);
    document.getElementById('modal-btn-hapus').addEventListener('click', function () {
        if (window._deleteFormId) {
            document.getElementById(window._deleteFormId).submit();
        }
    });
    document.getElementById('modal-delete-overlay').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });

    // ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
});

function openDeleteModal(formId, title, name) {
    window._deleteFormId = formId;
    document.getElementById('modal-title').textContent       = title;
    document.getElementById('modal-type-label').textContent  = name.prefix ?? '';
    document.getElementById('modal-item-name').textContent   = name.value ?? name;
    const overlay = document.getElementById('modal-delete-overlay');
    overlay.style.display = 'flex';
    // Animasi masuk
    overlay.querySelector('div').style.transform = 'scale(0.95)';
    overlay.querySelector('div').style.transition = 'transform 0.15s ease';
    requestAnimationFrame(() => {
        overlay.querySelector('div').style.transform = 'scale(1)';
    });
}

function closeDeleteModal() {
    const overlay = document.getElementById('modal-delete-overlay');
    if (overlay) {
        overlay.querySelector('div').style.transform = 'scale(0.95)';
        setTimeout(() => { overlay.style.display = 'none'; }, 120);
    }
    window._deleteFormId = null;
}

// ── Periode ──────────────────────────────────────────────────────
function confirmDeletePeriode(id, tahunAjaran) {
    openDeleteModal(
        `delete-periode-form-${id}`,
        'Hapus Periode PPDB?',
        { prefix: 'Periode', value: tahunAjaran }
    );
}

// ── Jurusan ──────────────────────────────────────────────────────
function confirmDeleteJurusan(id, namaJurusan) {
    openDeleteModal(
        `delete-jurusan-form-${id}`,
        'Hapus Jurusan?',
        { prefix: 'Jurusan', value: namaJurusan }
    );
}
</script>
@endpush