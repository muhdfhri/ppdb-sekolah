@extends('layouts.admin')

@section('title', 'Data Pendaftar')

@section('content')

    {{-- ── Page Header ──────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Pendaftar</h2>
            <p class="text-slate-500 mt-1">Kelola seluruh data pendaftar PPDB</p>
        </div>
    </div>

    {{-- ── Filter & Search ─────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-6">
        <form method="GET" action="{{ route('admin.pendaftar.index') }}" class="flex flex-wrap gap-4 items-end">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-slate-500 mb-2">Cari Nama / NISN</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-9 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary"
                        placeholder="Nama lengkap atau NISN..." />
                </div>
            </div>

            {{-- Filter Status --}}
            <div class="min-w-[160px]">
                <label class="block text-xs font-semibold text-slate-500 mb-2">Status</label>
                <select name="status"
                    class="w-full py-2.5 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="menunggu_pembayaran" {{ request('status') === 'menunggu_pembayaran' ? 'selected' : '' }}>
                        Menunggu Pembayaran</option>
                    <option value="menunggu_verifikasi" {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}>
                        Menunggu Verifikasi</option>
                    <option value="terverifikasi" {{ request('status') === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi
                    </option>
                    <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            {{-- Filter Jurusan --}}
            <div class="min-w-[160px]">
                <label class="block text-xs font-semibold text-slate-500 mb-2">Jurusan</label>
                <select name="jurusan_id"
                    class="w-full py-2.5 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan ?? [] as $j)
                        <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                            {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Submit --}}
            <div class="flex gap-2">
                <button type="submit"
                    class="px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 transition-opacity flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">filter_list</span>
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'jurusan_id']))
                    <a href="{{ route('admin.pendaftar.index') }}"
                        class="px-5 py-2.5 border border-slate-200 dark:border-slate-700 text-slate-500 rounded-xl text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ── Stats Mini ───────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @php
            $miniStats = [
                ['label' => 'Total', 'value' => $stats['total'] ?? 0, 'color' => 'text-blue-600', 'bg' => 'bg-blue-50'],
                ['label' => 'Draft', 'value' => $stats['draft'] ?? 0, 'color' => 'text-slate-600', 'bg' => 'bg-slate-100'],
                ['label' => 'Verifikasi', 'value' => $stats['menunggu_verifikasi'] ?? 0, 'color' => 'text-orange-600', 'bg' => 'bg-orange-50'],
                ['label' => 'Diterima', 'value' => $stats['diterima'] ?? 0, 'color' => 'text-green-600', 'bg' => 'bg-green-50'],
                ['label' => 'Ditolak', 'value' => $stats['ditolak'] ?? 0, 'color' => 'text-red-600', 'bg' => 'bg-red-50'],
            ];
        @endphp
        @foreach($miniStats as $s)
            <div
                class="bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-800 px-5 py-4 flex items-center gap-4">
                <div
                    class="size-10 rounded-lg {{ $s['bg'] }} flex items-center justify-center {{ $s['color'] }} font-extrabold text-lg">
                    {{ number_format($s['value']) }}
                </div>
                <p class="text-xs font-semibold text-slate-500">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ── Tabel Pendaftar ──────────────────────────────────── --}}
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-slate-800/50 text-[10px] uppercase tracking-wider font-bold text-slate-500">
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">No. Pendaftaran</th>
                        <th class="px-6 py-4">NISN</th>
                        <th class="px-6 py-4">Asal Sekolah</th>
                        <th class="px-6 py-4">Jurusan</th>
                        <th class="px-6 py-4">Tanggal Daftar</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($pendaftaran ?? [] as $i => $p)
                        @php
                            $nama = $p->siswa->nama_lengkap ?? $p->user->nama_lengkap ?? 'Tidak ada data';
                            $inisial = strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $nama), 0, 2))));
                            $statusConfig = [
                                'diterima' => ['dot' => 'bg-green-500', 'text' => 'text-green-700', 'bg' => 'bg-green-50', 'label' => 'Diterima'],
                                'ditolak' => ['dot' => 'bg-red-500', 'text' => 'text-red-700', 'bg' => 'bg-red-50', 'label' => 'Ditolak'],
                                'menunggu_verifikasi' => ['dot' => 'bg-orange-500', 'text' => 'text-orange-700', 'bg' => 'bg-orange-50', 'label' => 'Menunggu Verifikasi'],
                                'menunggu_pembayaran' => ['dot' => 'bg-purple-500', 'text' => 'text-purple-700', 'bg' => 'bg-purple-50', 'label' => 'Menunggu Pembayaran'],
                                'terverifikasi' => ['dot' => 'bg-primary', 'text' => 'text-primary', 'bg' => 'bg-primary/10', 'label' => 'Terverifikasi'],
                                'draft' => ['dot' => 'bg-slate-300', 'text' => 'text-slate-500', 'bg' => 'bg-slate-100', 'label' => 'Draft'],
                            ];
                            $sc = $statusConfig[$p->status] ?? ['dot' => 'bg-slate-300', 'text' => 'text-slate-500', 'bg' => 'bg-slate-100', 'label' => $p->status];
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors" id="row-{{ $p->id }}">
                            <td class="px-6 py-4 text-sm text-slate-400 font-medium">
                                {{ $pendaftaran->firstItem() + $i }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ $inisial }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{ $nama }}</p>
                                        <p class="text-[10px] text-slate-400">
                                            {{ $p->siswa->tempat_lahir ?? $p->user->email ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs font-mono text-slate-600 dark:text-slate-400">
                                {{ $p->nomor_pendaftaran }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $p->siswa->nisn ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 max-w-[160px] truncate">
                                {{ $p->sekolahAsal->nama_sekolah ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 rounded-full text-[10px] font-bold">
                                    {{ $p->jurusan->kode_jurusan ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $p->tanggal_daftar->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                                    <span class="size-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                    {{ $sc['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.pendaftar.show', $p->id) }}"
                                        class="p-2 text-slate-400 hover:text-primary transition-colors inline-block rounded-lg hover:bg-primary/5"
                                        title="Lihat Detail">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                    @if(in_array($p->status, ['draft', 'menunggu_verifikasi', 'menunggu_pembayaran']))
                                        <button type="button"
                                            onclick="confirmDelete({{ $p->id }}, '{{ addslashes($nama) }}', '{{ $p->nomor_pendaftaran }}')"
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors rounded-lg"
                                            title="Hapus Data">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    @endif
                                    <form id="delete-form-{{ $p->id }}" action="{{ route('admin.pendaftar.destroy', $p->id) }}"
                                        method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-8 py-16 text-center">
                                <span class="material-symbols-outlined text-5xl text-slate-300 block mb-3">person_search</span>
                                <p class="text-slate-400 font-semibold">Tidak ada data pendaftar</p>
                                <p class="text-slate-300 text-sm mt-1">Coba ubah filter pencarian</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($pendaftaran) && $pendaftaran->hasPages())
            <div class="px-8 py-5 border-t border-slate-100 dark:border-slate-800">
                {{ $pendaftaran->withQueryString()->links() }}
            </div>
        @endif
    </div>

    {{-- ── Delete Confirm Modal (sama seperti pengumuman) ──────── --}}
    <div id="modal-delete" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
        style="background-color: rgba(0,0,0,0.5);">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6">
            <div class="size-14 rounded-full flex items-center justify-center mx-auto mb-4"
                style="background-color: rgba(239,68,68,0.1);">
                <span class="material-symbols-outlined text-2xl text-red-500">warning</span>
            </div>
            <h3 class="text-center font-bold text-slate-900 dark:text-white text-lg">Hapus Data Pendaftar?</h3>
            <p class="text-center text-slate-500 text-sm mt-2">
                Data pendaftar "<span id="modal-nama" class="font-semibold text-slate-700"></span>"<br>
                No. Pendaftaran: <span id="modal-nomor" class="font-semibold text-slate-700"></span><br><br>
                <span class="text-red-600 text-xs">⚠️ Semua data terkait (siswa, dokumen, pembayaran, dll) akan dihapus
                    permanen!</span>
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
        // ── Delete Modal (sama persis seperti pengumuman) ────────────────
        let deleteTargetId = null;

        function confirmDelete(id, nama, nomorPendaftaran) {
            deleteTargetId = id;
            document.getElementById('modal-nama').textContent = nama;
            document.getElementById('modal-nomor').textContent = nomorPendaftaran;
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
        document.getElementById('modal-delete').addEventListener('click', function (e) {
            if (e.target === this) closeModal();
        });
    </script>
@endpush