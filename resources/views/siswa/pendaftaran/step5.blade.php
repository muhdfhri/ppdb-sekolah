@extends('layouts.siswa')

@section('title', 'Langkah 5 - Upload Dokumen | PPDB SMK NU II Medan')
@section('breadcrumb_parent', 'Pendaftaran')
@section('breadcrumb', 'Langkah 5: Upload Dokumen')

@section('content')
<div class="space-y-6 lg:space-y-8 max-w-7xl w-full">

    @include('siswa.partials.stepper', ['currentStep' => 5])

    @if($errors->any())
    <div class="flex items-start gap-3 p-4 rounded-xl text-sm bg-red-50 border border-red-200 text-red-600">
        <span class="material-symbols-outlined shrink-0 mt-0.5 text-base">error</span>
        <ul class="flex-1 list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 shadow-sm border border-slate-200">
        <div class="mb-6 lg:mb-8">
            <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Registrasi Siswa Baru</h2>
            <p class="text-sm lg:text-base text-slate-500 mt-1">Langkah 5: Upload dokumen persyaratan & bukti pembayaran.</p>
        </div>

        <form action="{{ route('siswa.pendaftaran.step5.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- ── Dokumen Persyaratan ────────────────────── --}}
            <div class="space-y-4">
                @php
                    $docList = [
                        ['key'=>'ijazah',        'label'=>'Ijazah / SKL',      'desc'=>'Scan ijazah/SKL yang dilegalisir',                      'icon'=>'description',    'required'=>true,  'accept'=>'.pdf,.jpg,.jpeg,.png'],
                        ['key'=>'kartu_keluarga', 'label'=>'Kartu Keluarga',   'desc'=>'Scan KK terbaru (semua anggota terlihat)',               'icon'=>'group',          'required'=>true,  'accept'=>'.pdf,.jpg,.jpeg,.png'],
                        ['key'=>'akte_kelahiran', 'label'=>'Akta Kelahiran',   'desc'=>'Scan akta kelahiran asli',                              'icon'=>'badge',          'required'=>true,  'accept'=>'.pdf,.jpg,.jpeg,.png'],
                        ['key'=>'pas_foto',       'label'=>'Pas Foto 3x4',     'desc'=>'Foto formal, latar merah, format JPG/PNG',              'icon'=>'photo_camera',   'required'=>true,  'accept'=>'.jpg,.jpeg,.png'],
                        ['key'=>'kip',            'label'=>'KIP / KPS / PKH',  'desc'=>'Jika memiliki kartu bantuan pemerintah (opsional)',     'icon'=>'card_membership','required'=>false, 'accept'=>'.pdf,.jpg,.jpeg,.png'],
                    ];
                @endphp

                @foreach($docList as $doc)
                @php $uploaded = $dokumen[$doc['key']] ?? null; @endphp
                <div class="p-4 lg:p-5 rounded-xl border-2 transition-all" id="wrap-{{ $doc['key'] }}"
                    style="border-color:{{ $uploaded ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $uploaded ? 'rgba(1,139,62,0.04)' : '#f8fafc' }};">
                    <div class="flex items-start gap-3 lg:gap-4">
                        <div class="size-10 lg:size-12 rounded-xl flex items-center justify-center shrink-0 text-white" style="background-color:#018B3E;">
                            <span class="material-symbols-outlined text-xl lg:text-2xl">{{ $doc['icon'] }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm lg:text-base font-semibold text-slate-900">
                                {{ $doc['label'] }}
                                @if($doc['required']) <span class="text-red-500">*</span> @endif
                            </p>
                            <p class="text-[10px] lg:text-xs text-slate-500 mt-0.5">{{ $doc['desc'] }}</p>
                            @if($uploaded)
                                <div class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    <span class="truncate max-w-[200px]">{{ $uploaded->nama_file }}</span>
                                </div>
                            @endif
                            <label class="mt-2 lg:mt-3 flex items-center gap-2 cursor-pointer" for="file-{{ $doc['key'] }}">
                                <div class="flex-1 px-3 lg:px-4 py-2 lg:py-2.5 rounded-lg border-2 border-dashed text-xs lg:text-sm text-slate-400 flex items-center gap-2"
                                    style="border-color:rgba(1,139,62,0.25);">
                                    <span class="material-symbols-outlined text-sm lg:text-base">upload_file</span>
                                    <span id="text-{{ $doc['key'] }}" class="truncate max-w-[200px]">
                                        {{ $uploaded ? 'Klik untuk ganti file' : 'Klik untuk pilih file' }}
                                    </span>
                                </div>
                                <input id="file-{{ $doc['key'] }}" type="file"
                                    name="{{ $doc['key'] }}"
                                    accept="{{ $doc['accept'] }}"
                                    class="sr-only"
                                    {{ $doc['required'] && !$uploaded ? 'required' : '' }}
                                    onchange="handleFileSelect(this, '{{ $doc['key'] }}')">
                            </label>
                            @error($doc['key']) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        @if($uploaded)
                        <span class="shrink-0 inline-flex items-center gap-1 text-[10px] lg:text-xs font-bold px-2 py-1 rounded-full"
                            style="background-color:rgba(1,139,62,0.1); color:#018B3E;">
                            <span class="material-symbols-outlined text-xs lg:text-sm">check_circle</span>
                            <span class="hidden sm:inline">Terupload</span>
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ── Bukti Pembayaran ───────────────────────── --}}
            <div class="pt-6 mt-6 border-t-2 border-dashed border-[#018B3E]/30">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#018B3E] flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-xl">receipt</span>
                    </div>
                    <div>
                        <h3 class="text-base lg:text-lg font-bold text-[#018B3E]">Bukti Pembayaran</h3>
                        <p class="text-xs text-slate-500">Upload bukti transfer / pembayaran pendaftaran</p>
                    </div>
                </div>

                <div class="mb-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-blue-600 text-base shrink-0 mt-0.5">payments</span>
                        <div class="text-xs lg:text-sm">
                            <p class="font-semibold text-slate-800">Informasi Pembayaran</p>
                            @if(($periodeInfo['biaya'] ?? 0) > 0)
                                <p class="text-slate-600 mt-1">Biaya: <span class="font-bold" style="color:#018B3E;">Rp {{ number_format($periodeInfo['biaya'], 0, ',', '.') }}</span></p>
                                <p class="text-slate-600 mt-1">Bank Syariah Indonesia (BSI) — 1234567890 a.n. SMK NU II Medan</p>
                            @else
                                <p class="text-slate-600 mt-1">Biaya pendaftaran: <span class="font-bold text-green-600">GRATIS</span></p>
                                <p class="text-slate-600 mt-1">Tetap upload bukti pembayaran sebagai tanda registrasi.</p>
                            @endif
                        </div>
                    </div>
                </div>

                @php $buktiBayar = $dokumen['bukti_pembayaran'] ?? null; @endphp
                <div class="p-4 lg:p-5 rounded-xl border-2 transition-all" id="wrap-bukti_pembayaran"
                    style="border-color:{{ $buktiBayar ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $buktiBayar ? 'rgba(1,139,62,0.04)' : '#f8fafc' }};">
                    <div class="flex items-start gap-3 lg:gap-4">
                        <div class="size-10 lg:size-12 rounded-xl flex items-center justify-center shrink-0 text-white" style="background-color:#018B3E;">
                            <span class="material-symbols-outlined text-xl lg:text-2xl">receipt</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm lg:text-base font-semibold text-slate-900">
                                Bukti Pembayaran <span class="text-red-500">*</span>
                            </p>
                            <p class="text-[10px] lg:text-xs text-slate-500 mt-0.5">PDF/JPG/PNG, maks 2MB</p>
                            @if($buktiBayar)
                                <div class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    <span class="truncate max-w-[200px]">{{ $buktiBayar->nama_file }}</span>
                                </div>
                            @endif
                            <label class="mt-2 lg:mt-3 flex items-center gap-2 cursor-pointer" for="file-bukti_pembayaran">
                                <div class="flex-1 px-3 lg:px-4 py-2 lg:py-2.5 rounded-lg border-2 border-dashed text-xs lg:text-sm text-slate-400 flex items-center gap-2"
                                    style="border-color:rgba(1,139,62,0.25);">
                                    <span class="material-symbols-outlined text-sm lg:text-base">upload_file</span>
                                    <span id="text-bukti_pembayaran" class="truncate max-w-[200px]">
                                        {{ $buktiBayar ? 'Klik untuk ganti file' : 'Klik untuk pilih file' }}
                                    </span>
                                </div>
                                <input id="file-bukti_pembayaran" type="file" name="bukti_pembayaran"
                                    accept=".pdf,.jpg,.jpeg,.png" class="sr-only"
                                    {{ !$buktiBayar ? 'required' : '' }}
                                    onchange="handleFileSelect(this, 'bukti_pembayaran')">
                            </label>
                            @error('bukti_pembayaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        @if($buktiBayar)
                        <span class="shrink-0 inline-flex items-center gap-1 text-[10px] lg:text-xs font-bold px-2 py-1 rounded-full"
                            style="background-color:rgba(1,139,62,0.1); color:#018B3E;">
                            <span class="material-symbols-outlined text-xs lg:text-sm">check_circle</span>
                            <span class="hidden sm:inline">Terupload</span>
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="p-3 lg:p-4 rounded-xl flex items-start gap-2 lg:gap-3 bg-yellow-50 border border-yellow-200">
                <span class="material-symbols-outlined shrink-0 mt-0.5 text-amber-600 text-base lg:text-lg">info</span>
                <div class="text-xs lg:text-sm">
                    <p class="font-semibold text-slate-800">Pastikan dokumen Anda valid</p>
                    <p class="text-slate-600 mt-0.5">File harus terbaca jelas. Format: PDF, JPG, atau PNG. Ukuran maksimal 2MB per file.</p>
                </div>
            </div>

            <div class="pt-6 lg:pt-8 flex flex-col-reverse sm:flex-row gap-3 lg:gap-4" style="border-top:1px solid #f1f5f9;">
                <a href="{{ route('siswa.pendaftaran.step4') }}"
                    class="sm:flex-1 py-3 lg:py-4 px-6 rounded-xl font-bold text-sm lg:text-base text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                </a>
                <button type="submit"
                    class="sm:flex-[2] py-3 lg:py-4 px-6 rounded-xl font-bold text-sm lg:text-base text-white transition-all flex items-center justify-center gap-2"
                    style="background-color:#018B3E; box-shadow:0 8px 24px rgba(1,139,62,0.25);"
                    onmouseover="this.style.backgroundColor='#016b30';" onmouseout="this.style.backgroundColor='#018B3E';">
                    <span class="material-symbols-outlined text-lg">send</span> Kirim Pendaftaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function handleFileSelect(input, docName) {
    const file = input.files[0];
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar! Maksimal 2MB.');
        input.value = '';
        return;
    }
    const textEl = document.getElementById('text-' + docName);
    if (textEl) textEl.textContent = file.name;
    const wrap = document.getElementById('wrap-' + docName);
    if (wrap) {
        wrap.style.borderColor     = '#018B3E';
        wrap.style.backgroundColor = 'rgba(1,139,62,0.04)';
    }
}
</script>
@endpush