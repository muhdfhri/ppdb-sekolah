{{-- resources/views/admin/pendaftar/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Pendaftar')

@section('content')

    @php
        $statusConfig = [
            'diterima' => ['dot' => 'bg-green-500', 'text' => 'text-green-700', 'bg' => 'bg-green-50  dark:bg-green-900/20', 'label' => 'Diterima'],
            'ditolak' => ['dot' => 'bg-red-500', 'text' => 'text-red-700', 'bg' => 'bg-red-50    dark:bg-red-900/20', 'label' => 'Ditolak'],
            'menunggu_verifikasi' => ['dot' => 'bg-orange-500', 'text' => 'text-orange-700', 'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'label' => 'Menunggu Verifikasi'],
            'terverifikasi' => ['dot' => 'bg-primary', 'text' => 'text-primary', 'bg' => 'bg-primary/10', 'label' => 'Terverifikasi'],
            'draft' => ['dot' => 'bg-slate-300', 'text' => 'text-slate-500', 'bg' => 'bg-slate-100 dark:bg-slate-800', 'label' => 'Draft'],
        ];
        $sc = $statusConfig[$pendaftaran->status] ?? $statusConfig['draft'];
        $nama = $pendaftaran->siswa->nama_lengkap ?? $pendaftaran->user->nama_lengkap ?? 'Tidak Diketahui';
        $inisial = $nama !== 'Tidak Diketahui'
            ? strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $nama), 0, 2))))
            : '??';
    @endphp

    {{-- ── Breadcrumb & Actions ─────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <a href="{{ route('admin.pendaftar.index') }}" class="hover:text-primary transition-colors">Calon Siswa</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-slate-600 font-semibold">Detail</span>
            </nav>
            <h2 class="text-3xl font-extrabold tracking-tight">Detail Pendaftar</h2>
            <p class="text-slate-500 mt-1 font-mono text-sm">{{ $pendaftaran->nomor_pendaftaran ?? '-' }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pendaftar.index') }}"
                class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
            <a href="#" onclick="window.print()"
                class="flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl text-sm font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                <span class="material-symbols-outlined text-lg">print</span>
                Cetak
            </a>
        </div>
    </div>

    {{-- ── Hero Card ────────────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div
                class="size-20 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-extrabold text-2xl shrink-0">
                {{ $inisial }}
            </div>
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-3 mb-1">
                    <h3 class="text-xl font-extrabold">{{ $nama }}</h3>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                        <span class="size-2 rounded-full {{ $sc['dot'] }}"></span>
                        {{ $sc['label'] }}
                    </span>
                </div>
                <p class="text-slate-500 text-sm">{{ $pendaftaran->user->email ?? '-' }}</p>
                <div class="flex flex-wrap gap-4 mt-3 text-xs text-slate-500">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-primary">school</span>
                        {{ $pendaftaran->jurusan->nama_jurusan ?? 'Belum dipilih' }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-primary">calendar_today</span>
                        Daftar:
                        {{ $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->translatedFormat('d M Y, H:i') : '-' }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-primary">stairs</span>
                        Step {{ $pendaftaran->step_terakhir ?? 1 }} / 5
                    </span>
                </div>
            </div>

            {{-- Aksi Verifikasi --}}
            @if(in_array($pendaftaran->status, ['menunggu_verifikasi', 'terverifikasi']))
                <div class="flex gap-2 shrink-0">
                    <form method="POST" action="{{ route('admin.pendaftar.terima', $pendaftaran->id) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition-opacity">
                            <span class="material-symbols-outlined text-lg">check_circle</span>
                            Terima
                        </button>
                    </form>
                    <button onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                        class="flex items-center gap-2 px-5 py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-xl text-sm font-bold hover:bg-red-100 transition-colors">
                        <span class="material-symbols-outlined text-lg">cancel</span>
                        Tolak
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- ── Data Grid ────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri (Data Pribadi + Sekolah + Ortu) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Data Pribadi --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h4 class="font-bold">Data Pribadi</h4>
                </div>
                <div class="p-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @php
                        $pribadi = [
                            ['label' => 'NIK', 'value' => $pendaftaran->siswa->nik ?? '-'],
                            ['label' => 'Nama Lengkap', 'value' => $pendaftaran->siswa->nama_lengkap ?? '-'],
                            ['label' => 'Tempat Lahir', 'value' => $pendaftaran->siswa->tempat_lahir ?? '-'],
                            ['label' => 'Tanggal Lahir', 'value' => isset($pendaftaran->siswa->tanggal_lahir) ? \Carbon\Carbon::parse($pendaftaran->siswa->tanggal_lahir)->translatedFormat('d M Y') : '-'],
                            ['label' => 'Jenis Kelamin', 'value' => $pendaftaran->siswa->jenis_kelamin ?? '-'],
                            ['label' => 'Agama', 'value' => $pendaftaran->siswa->agama ?? '-'],
                            ['label' => 'No. Telepon', 'value' => $pendaftaran->siswa->no_telepon ?? '-'],
                            ['label' => 'Email', 'value' => $pendaftaran->siswa->email ?? '-'],
                            ['label' => 'Alamat', 'value' => $pendaftaran->siswa->alamat_lengkap ?? '-', 'full' => true],
                        ];
                    @endphp
                    @foreach($pribadi as $field)
                        <div class="{{ ($field['full'] ?? false) ? 'sm:col-span-2' : '' }}">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">{{ $field['label'] }}
                            </p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $field['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Sekolah Asal --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">account_balance</span>
                    <h4 class="font-bold">Sekolah Asal</h4>
                </div>
                <div class="p-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @php
                        $sekolah = [
                            ['label' => 'Nama Sekolah', 'value' => $pendaftaran->sekolahAsal->nama_sekolah ?? '-', 'full' => true],
                            ['label' => 'NISN', 'value' => $pendaftaran->sekolahAsal->nisn ?? '-'],
                            ['label' => 'Tahun Lulus', 'value' => $pendaftaran->sekolahAsal->tahun_lulus ?? '-'],
                            ['label' => 'Nilai Rata-rata', 'value' => $pendaftaran->sekolahAsal->nilai_rata_rata ?? '-'],
                            ['label' => 'Alamat Sekolah', 'value' => $pendaftaran->sekolahAsal->alamat_sekolah ?? '-', 'full' => true],
                        ];
                    @endphp
                    @foreach($sekolah as $field)
                        <div class="{{ ($field['full'] ?? false) ? 'sm:col-span-2' : '' }}">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">{{ $field['label'] }}
                            </p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $field['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Orang Tua --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">family_restroom</span>
                    <h4 class="font-bold">Data Orang Tua</h4>
                </div>
                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach(['ayah' => 'Ayah', 'ibu' => 'Ibu'] as $jenis => $label)
                        @php $ortu = $pendaftaran->orangTua->firstWhere('jenis', $jenis); @endphp
                        <div class="p-8">
                            <p class="text-xs font-extrabold uppercase tracking-wider text-primary mb-5">{{ $label }}</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @php
                                    $ortuFields = [
                                        ['label' => 'Nama Lengkap', 'value' => $ortu->nama_lengkap ?? '-'],
                                        ['label' => 'NIK', 'value' => $ortu->nik ?? '-'],
                                        ['label' => 'Tempat Lahir', 'value' => $ortu->tempat_lahir ?? '-'],
                                        ['label' => 'Tanggal Lahir', 'value' => isset($ortu->tanggal_lahir) ? \Carbon\Carbon::parse($ortu->tanggal_lahir)->translatedFormat('d M Y') : '-'],
                                        ['label' => 'Pekerjaan', 'value' => $ortu->pekerjaan ?? '-'],
                                        ['label' => 'Penghasilan', 'value' => $ortu->penghasilan ?? '-'],
                                        ['label' => 'No. Telepon', 'value' => $ortu->no_telepon ?? '-'],
                                        ['label' => 'Alamat', 'value' => $ortu->alamat ?? '-', 'full' => true],
                                    ];
                                @endphp
                                @foreach($ortuFields as $field)
                                    <div class="{{ ($field['full'] ?? false) ? 'sm:col-span-2' : '' }}">
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                            {{ $field['label'] }}</p>
                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $field['value'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Kolom Kanan (Jurusan + Dokumen + Bukti Pembayaran + Log) --}}
        <div class="space-y-6">

            {{-- Pilihan Jurusan --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">school</span>
                    <h4 class="font-bold">Pilihan Jurusan</h4>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-primary/5 rounded-xl border border-primary/20">
                        <div
                            class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                            1</div>
                        <div>
                            <p class="text-xs text-slate-400">Pilihan Pertama</p>
                            <p class="text-sm font-bold">{{ $pendaftaran->jurusan->nama_jurusan ?? '—' }}</p>
                        </div>
                    </div>
                    @if($pendaftaran->jurusan_id_2 && $pendaftaran->jurusanPilihan2)
                        <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl">
                            <div
                                class="size-8 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 font-bold text-xs">
                                2</div>
                            <div>
                                <p class="text-xs text-slate-400">Pilihan Kedua</p>
                                <p class="text-sm font-bold">{{ $pendaftaran->jurusanPilihan2->nama_jurusan }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Dokumen Persyaratan --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">description</span>
                    <h4 class="font-bold">Dokumen Persyaratan</h4>
                </div>
                <div class="p-6 space-y-3">
                    @php
                        $jenisDokumen = [
                            'ijazah' => 'Ijazah / SKL',
                            'kartu_keluarga' => 'Kartu Keluarga',
                            'akte_kelahiran' => 'Akta Kelahiran',
                            'pas_foto' => 'Pas Foto 3x4',
                        ];
                        $dokumenMap = $pendaftaran->dokumen->keyBy('jenis_dokumen');
                    @endphp
                    @foreach($jenisDokumen as $key => $labelDok)
                        @php $dok = $dokumenMap[$key] ?? null; @endphp
                        <div
                            class="flex items-center justify-between p-3 rounded-xl {{ $dok ? 'bg-slate-50 dark:bg-slate-800' : 'bg-red-50/50 dark:bg-red-900/10' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="material-symbols-outlined text-lg {{ $dok ? 'text-primary' : 'text-slate-300' }}">
                                    {{ $dok ? 'check_circle' : 'radio_button_unchecked' }}
                                </span>
                                <span
                                    class="text-xs font-semibold truncate {{ $dok ? 'text-slate-700 dark:text-slate-300' : 'text-slate-400' }}">
                                    {{ $labelDok }}
                                </span>
                            </div>
                            @if($dok)
                                <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank"
                                    class="shrink-0 text-xs text-primary font-bold hover:underline ml-2">
                                    Lihat
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ★ CARD BARU: Bukti Pembayaran (ditempatkan di antara Dokumen dan Riwayat) --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">receipt</span>
                    <h4 class="font-bold">Bukti Pembayaran</h4>
                </div>
                <div class="p-6">
                    @php
                        $buktiPembayaran = $pendaftaran->dokumen->where('jenis_dokumen', 'bukti_pembayaran')->first();
                    @endphp
                    
                    @if($buktiPembayaran)
                        <div class="space-y-4">
                            {{-- Status Upload --}}
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-green-600 text-lg">check_circle</span>
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Sudah diupload</span>
                                </div>
                                <span class="text-xs text-slate-500">
                                    {{ $buktiPembayaran->created_at->translatedFormat('d M Y H:i') }}
                                </span>
                            </div>

                            {{-- Info File --}}
                            <div class="p-4 bg-slate-50 dark:bg-slate-800 rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold text-slate-500">Nama File</span>
                                    <span class="text-[10px] text-slate-400">
                                        {{ round($buktiPembayaran->ukuran_file / 1024, 2) }} KB
                                    </span>
                                </div>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 break-all">
                                    {{ $buktiPembayaran->nama_file }}
                                </p>
                            </div>

                            {{-- Status Verifikasi --}}
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold text-slate-500">Status Verifikasi</span>
                                @if($buktiPembayaran->status_verifikasi == 'valid')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold flex items-center gap-1">
                                        <span class="size-1.5 bg-green-500 rounded-full"></span>
                                        Terverifikasi
                                    </span>
                                @elseif($buktiPembayaran->status_verifikasi == 'tidak_valid')
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold flex items-center gap-1">
                                        <span class="size-1.5 bg-red-500 rounded-full"></span>
                                        Tidak Valid
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold flex items-center gap-1">
                                        <span class="size-1.5 bg-yellow-500 rounded-full"></span>
                                        Menunggu
                                    </span>
                                @endif
                            </div>

                            {{-- Catatan Admin (jika ada) --}}
                            @if($buktiPembayaran->catatan)
                                <div class="p-3 bg-yellow-50 dark:bg-yellow-900/10 rounded-xl">
                                    <p class="text-[10px] font-bold text-yellow-700 dark:text-yellow-400 mb-1">Catatan:</p>
                                    <p class="text-xs text-slate-600 dark:text-slate-400">{{ $buktiPembayaran->catatan }}</p>
                                </div>
                            @endif

                            {{-- Tombol Aksi --}}
                            <div class="flex gap-2 pt-2">
                                <a href="{{ asset('storage/' . $buktiPembayaran->file_path) }}" target="_blank"
                                    class="flex-1 flex items-center justify-center gap-1 py-2 bg-primary text-white rounded-lg text-xs font-bold hover:bg-primary/90 transition-all">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    Lihat Bukti
                                </a>
                                <a href="{{ asset('storage/' . $buktiPembayaran->file_path) }}" download
                                    class="flex items-center justify-center gap-1 py-2 px-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-lg text-xs font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                                    <span class="material-symbols-outlined text-sm">download</span>
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- Belum ada bukti pembayaran --}}
                        <div class="text-center py-8">
                            <span class="material-symbols-outlined text-4xl text-slate-300 block mb-3">receipt</span>
                            <p class="text-sm font-semibold text-slate-500">Belum ada bukti pembayaran</p>
                            <p class="text-xs text-slate-400 mt-1">Siswa belum mengupload bukti pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Riwayat Verifikasi --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">history</span>
                    <h4 class="font-bold">Riwayat</h4>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($pendaftaran->verifikasiLog as $log)
                        <div class="flex gap-3">
                            <div
                                class="size-7 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-sm">person</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold">{{ $log->admin->nama_lengkap ?? 'Admin' }}</p>
                                <p class="text-[10px] text-slate-500">
                                    {{ $log->status_sebelum ?? '-' }} → <span
                                        class="font-bold text-primary">{{ $log->status_sesudah }}</span>
                                </p>
                                @if($log->catatan)
                                    <p class="text-[10px] text-slate-400 mt-1 italic">"{{ $log->catatan }}"</p>
                                @endif
                                <p class="text-[10px] text-slate-300 mt-1">
                                    {{ $log->created_at ? $log->created_at->translatedFormat('d M Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada riwayat verifikasi</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- ── Modal Tolak ──────────────────────────────────────── --}}
    <div id="modal-tolak" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4">
            <div class="flex items-center gap-3 mb-6">
                <div class="size-12 rounded-xl bg-red-50 flex items-center justify-center text-red-600">
                    <span class="material-symbols-outlined text-2xl">cancel</span>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Tolak Pendaftaran</h3>
                    <p class="text-xs text-slate-500">Berikan alasan penolakan</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.pendaftar.tolak', $pendaftaran->id) }}">
                @csrf @method('PATCH')
                <textarea name="catatan"
                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-400 resize-none"
                    rows="4" placeholder="Alasan penolakan..." required></textarea>
                <div class="flex gap-3 mt-5">
                    <button type="button" onclick="document.getElementById('modal-tolak').classList.add('hidden')"
                        class="flex-1 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-colors">
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Close modal when clicking outside
        document.getElementById('modal-tolak')?.addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modal-tolak');
                if (modal && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                }
            }
        });
    </script>
@endsection