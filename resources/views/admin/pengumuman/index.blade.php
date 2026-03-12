{{-- resources/views/admin/pengumuman/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')

{{-- ── Page Header ───────────────────────────────────────── --}}
<div class="flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Pengumuman</h2>
        <p class="text-sm text-slate-500 mt-0.5">Kelola pengumuman PPDB yang ditampilkan kepada calon siswa.</p>
    </div>
    <a href="{{ route('admin.pengumuman.create') }}"
        class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-sm transition-all hover:opacity-90"
        style="background-color: #01893e;">
        <span class="material-symbols-outlined text-base">add</span>
        Buat Pengumuman
    </a>
</div>

{{-- ── Stats Row ─────────────────────────────────────────── --}}
<div class="grid grid-cols-3 gap-4">
    @foreach([
        ['label' => 'Total Pengumuman', 'value' => $pengumuman->total(),                                                              'icon' => 'campaign',   'color' => '#01893e'],
        ['label' => 'Dipublish',         'value' => $pengumuman->getCollection()->where('is_published', true)->count(),               'icon' => 'visibility', 'color' => '#16a34a'],
        ['label' => 'Draft',             'value' => $pengumuman->getCollection()->where('is_published', false)->count(),              'icon' => 'edit_note',  'color' => '#64748b'],
    ] as $s)
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 flex items-center gap-4">
        <div class="size-11 rounded-xl flex items-center justify-center text-white shrink-0"
            style="background-color: {{ $s['color'] }};">
            <span class="material-symbols-outlined text-lg">{{ $s['icon'] }}</span>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $s['value'] }}</p>
            <p class="text-xs text-slate-500 font-medium">{{ $s['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- ── Table ─────────────────────────────────────────────── --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">

    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 dark:text-white text-sm">Daftar Pengumuman</h3>
        <span class="text-xs text-slate-400">{{ $pengumuman->total() }} total</span>
    </div>

    @if($pengumuman->isEmpty())
    <div class="py-20 text-center">
        <span class="material-symbols-outlined text-5xl block mb-3 text-slate-300">campaign</span>
        <p class="text-slate-500 font-semibold">Belum ada pengumuman</p>
        <p class="text-slate-400 text-sm mt-1">Klik "Buat Pengumuman" untuk menambahkan.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 dark:border-slate-800">
                    <th class="text-left px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Judul</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl. Publish</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Dibuat Oleh</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Dibuat</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($pengumuman as $p)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" id="row-{{ $p->id }}">

                    {{-- Judul --}}
                    <td class="px-6 py-4">
                        <div class="max-w-xs">
                            <p class="font-semibold text-slate-900 dark:text-white truncate">{{ $p->judul }}</p>
                            <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ Str::limit(strip_tags($p->isi), 60) }}</p>
                        </div>
                    </td>

                    {{-- Status + Toggle --}}
                    <td class="px-4 py-4">
                        <button onclick="togglePublish({{ $p->id }})"
                            id="badge-{{ $p->id }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold transition-all cursor-pointer"
                            style="{{ $p->is_published
                                ? 'background-color: rgba(22,163,74,0.1); color: #16a34a;'
                                : 'background-color: rgba(100,116,139,0.1); color: #64748b;' }}"
                            title="{{ $p->is_published ? 'Klik untuk unpublish' : 'Klik untuk publish' }}">
                            <span class="material-symbols-outlined text-sm" id="icon-{{ $p->id }}">
                                {{ $p->is_published ? 'visibility' : 'visibility_off' }}
                            </span>
                            <span id="label-{{ $p->id }}">{{ $p->is_published ? 'Published' : 'Draft' }}</span>
                        </button>
                    </td>

                    {{-- Tanggal Publish --}}
                    <td class="px-4 py-4 text-slate-500 text-xs">
                        @if($p->tanggal_publish)
                            {{ \Carbon\Carbon::parse($p->tanggal_publish)->format('d M Y, H:i') }}
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>

                    {{-- Created By --}}
                    <td class="px-4 py-4">
                        @if($p->createdBy)
                            <div class="flex items-center gap-2">
                                <div class="size-6 rounded-full flex items-center justify-center text-white text-[10px] font-bold shrink-0"
                                    style="background-color: #01893e;">
                                    {{ strtoupper(substr($p->createdBy->nama_lengkap ?? $p->createdBy->name, 0, 2)) }}
                                </div>
                                <span class="text-xs text-slate-600 dark:text-slate-400">
                                    {{ Str::limit($p->createdBy->nama_lengkap ?? $p->createdBy->name, 16) }}
                                </span>
                            </div>
                        @else
                            <span class="text-xs text-slate-300">—</span>
                        @endif
                    </td>

                    {{-- Created At --}}
                    <td class="px-4 py-4 text-slate-500 text-xs whitespace-nowrap">
                        {{ $p->created_at->format('d M Y') }}
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.pengumuman.edit', $p->id) }}"
                                class="p-2 rounded-lg transition-colors text-slate-500 hover:text-primary hover:bg-primary/5"
                                title="Edit">
                                <span class="material-symbols-outlined text-base">edit</span>
                            </a>
                            <button onclick="confirmDelete({{ $p->id }}, '{{ addslashes($p->judul) }}')"
                                class="p-2 rounded-lg transition-colors text-slate-500 hover:text-red-500 hover:bg-red-50"
                                title="Hapus">
                                <span class="material-symbols-outlined text-base">delete</span>
                            </button>
                            <form id="delete-form-{{ $p->id }}"
                                action="{{ route('admin.pengumuman.destroy', $p->id) }}"
                                method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($pengumuman->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
        {{ $pengumuman->links() }}
    </div>
    @endif
    @endif
</div>

@endsection

@push('scripts')
<script>
// ── Toggle Publish ──────────────────────────────────────────────
function togglePublish(id) {
    fetch(`/admin/pengumuman/${id}/toggle`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) return;
        const badge = document.getElementById(`badge-${id}`);
        const icon  = document.getElementById(`icon-${id}`);
        const label = document.getElementById(`label-${id}`);

        if (data.is_published) {
            badge.style.cssText = 'background-color: rgba(22,163,74,0.1); color: #16a34a;';
            icon.textContent    = 'visibility';
            label.textContent   = 'Published';
            badge.title         = 'Klik untuk unpublish';
        } else {
            badge.style.cssText = 'background-color: rgba(100,116,139,0.1); color: #64748b;';
            icon.textContent    = 'visibility_off';
            label.textContent   = 'Draft';
            badge.title         = 'Klik untuk publish';
        }
    })
    .catch(() => alert('Gagal mengubah status. Coba lagi.'));
}

// ── Delete Modal ─────────────────────────────────────────────────
// Modal di-inject langsung ke <body> agar tidak terkena overflow:hidden dari layout
let deleteTargetId = null;

// Buat elemen modal sekali saat DOM siap, append ke body
document.addEventListener('DOMContentLoaded', function () {
    const modalHTML = `
    <div id="modal-delete-overlay"
        style="display:none; position:fixed; inset:0; width:100vw; height:100vh;
               background:rgba(0,0,0,0.6); backdrop-filter:blur(3px);
               z-index:99999; align-items:center; justify-content:center; padding:1rem;">
        <div style="background:white; border-radius:1.25rem; box-shadow:0 25px 60px rgba(0,0,0,0.25);
                    width:100%; max-width:360px; padding:2rem;">
            <div style="width:56px; height:56px; border-radius:50%; background:rgba(239,68,68,0.1);
                        display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                <span class="material-symbols-outlined" style="font-size:28px; color:#ef4444;">warning</span>
            </div>
            <h3 style="text-align:center; font-weight:800; font-size:1.1rem; color:#0f172a; margin:0 0 0.5rem;">
                Hapus Pengumuman?
            </h3>
            <p style="text-align:center; color:#64748b; font-size:0.875rem; margin:0 0 1.5rem;">
                Pengumuman "<span id="modal-judul-text" style="font-weight:700; color:#334155;"></span>"
                akan dihapus permanen.
            </p>
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
                           border:none; cursor:pointer; transition:background 0.15s;"
                    onmouseover="this.style.background='#dc2626';"
                    onmouseout="this.style.background='#ef4444';">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>`;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Event listeners
    document.getElementById('modal-btn-batal').addEventListener('click', closeModal);
    document.getElementById('modal-btn-hapus').addEventListener('click', function () {
        if (deleteTargetId) {
            document.getElementById(`delete-form-${deleteTargetId}`).submit();
        }
    });
    document.getElementById('modal-delete-overlay').addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });
});

function confirmDelete(id, judul) {
    deleteTargetId = id;
    document.getElementById('modal-judul-text').textContent = judul;
    const overlay = document.getElementById('modal-delete-overlay');
    overlay.style.display = 'flex';
}

function closeModal() {
    const overlay = document.getElementById('modal-delete-overlay');
    if (overlay) overlay.style.display = 'none';
    deleteTargetId = null;
}
</script>
@endpush