{{-- resources/views/admin/pengumuman/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')

{{-- ── Page Header ───────────────────────────────────────── --}}
<div class="flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Pengumuman</h2>
        <p class="text-sm text-slate-500 mt-0.5">Kelola pengumuman PPDB yang ditampilkan kepada pendaftar.</p>
    </div>
    <a href="{{ route('admin.pengumuman.create') }}"
        class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-sm transition-all hover:opacity-90"
        style="background-color: #01893e;">
        <span class="material-symbols-outlined text-base">add</span>
        Buat Pengumuman
    </a>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold"
    style="background-color: rgba(1,137,62,0.08); border: 1px solid rgba(1,137,62,0.2); color: #015f2a;">
    <span class="material-symbols-outlined text-base">check_circle</span>
    {{ session('success') }}
</div>
@endif

{{-- ── Stats Row ─────────────────────────────────────────── --}}
@php
    $published = $pengumuman->getCollection()->where('is_published', true)->count();
    $draft     = $pengumuman->getCollection()->where('is_published', false)->count();
@endphp
<div class="grid grid-cols-3 gap-4">
    @foreach([
        ['label' => 'Total Pengumuman', 'value' => $pengumuman->total(), 'icon' => 'campaign', 'color' => '#01893e'],
        ['label' => 'Dipublish', 'value' => $published, 'icon' => 'visibility', 'color' => '#16a34a'],
        ['label' => 'Draft', 'value' => $draft, 'icon' => 'edit_note', 'color' => '#64748b'],
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

    {{-- Pagination --}}
    @if($pengumuman->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
        {{ $pengumuman->links() }}
    </div>
    @endif

    @endif
</div>

{{-- ── Delete Confirm Modal ──────────────────────────────── --}}
<div id="modal-delete" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
    style="background-color: rgba(0,0,0,0.5);">
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6">
        <div class="size-14 rounded-full flex items-center justify-center mx-auto mb-4"
            style="background-color: rgba(239,68,68,0.1);">
            <span class="material-symbols-outlined text-2xl text-red-500">warning</span>
        </div>
        <h3 class="text-center font-bold text-slate-900 dark:text-white text-lg">Hapus Pengumuman?</h3>
        <p class="text-center text-slate-500 text-sm mt-2">
            Pengumuman "<span id="modal-judul" class="font-semibold text-slate-700"></span>" akan dihapus permanen.
        </p>
        <div class="flex gap-3 mt-6">
            <button onclick="closeModal()"
                class="flex-1 py-2.5 rounded-xl font-bold text-sm text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                Batal
            </button>
            <button id="btn-confirm-delete"
                class="flex-1 py-2.5 rounded-xl font-bold text-sm text-white bg-red-500 hover:bg-red-600 transition-colors">
                Ya, Hapus
            </button>
        </div>
    </div>
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

// ── Delete Modal ────────────────────────────────────────────────
let deleteTargetId = null;

function confirmDelete(id, judul) {
    deleteTargetId = id;
    document.getElementById('modal-judul').textContent = judul;
    document.getElementById('modal-delete').classList.remove('hidden');
    document.getElementById('modal-delete').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal-delete').classList.add('hidden');
    document.getElementById('modal-delete').classList.remove('flex');
    deleteTargetId = null;
}

document.getElementById('btn-confirm-delete').addEventListener('click', () => {
    if (deleteTargetId) {
        document.getElementById(`delete-form-${deleteTargetId}`).submit();
    }
});

// Close modal on backdrop click
document.getElementById('modal-delete').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endpush