@extends('layouts.siswa')

@section('title', 'Langkah 4 - Pilih Jurusan | PPDB SMK NU II Medan')
@section('breadcrumb_parent', 'Pendaftaran')
@section('breadcrumb', 'Langkah 4: Pilih Jurusan')

@section('content')
<div class="space-y-6 lg:space-y-8 max-w-7xl w-full">

    @include('siswa.partials.stepper', ['currentStep' => 4])

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
            <p class="text-sm lg:text-base text-slate-500 mt-1">Langkah 4: Pilih kompetensi keahlian yang Anda minati.</p>
        </div>

        <form action="{{ route('siswa.pendaftaran.step4.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Pilihan Jurusan --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3 lg:mb-4">
                    Pilih Jurusan <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 lg:gap-4">
                    @foreach($jurusan as $j)
                    @php
                        $icons    = ['TKJ'=>'router','AKL'=>'calculate','BDP'=>'storefront','MM'=>'movie_creation'];
                        $icon     = $icons[$j->kode_jurusan] ?? 'school';
                        $selected = old('jurusan_id', $pendaftaran->jurusan_id ?? '') == $j->id;
                    @endphp
                    <label class="jurusan-label flex items-start gap-3 lg:gap-4 p-4 lg:p-5 rounded-xl border-2 cursor-pointer transition-all"
                        style="border-color:{{ $selected ? '#018B3E' : '#f1f5f9' }}; background-color:{{ $selected ? 'rgba(1,139,62,0.05)' : '#f8fafc' }};">
                        <input type="radio" name="jurusan_id" value="{{ $j->id }}" class="sr-only"
                            {{ $selected ? 'checked' : '' }} 
                            onchange="updateJurusan(this)">
                        <div class="size-10 lg:size-12 rounded-xl flex items-center justify-center shrink-0 text-white" style="background-color:#018B3E;">
                            <span class="material-symbols-outlined text-xl lg:text-2xl">{{ $icon }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm lg:text-base font-bold text-slate-900">{{ $j->nama_jurusan }}</p>
                            @if($j->deskripsi)
                                <p class="text-xs lg:text-sm text-slate-600 mt-1.5 leading-relaxed line-clamp-2">{{ $j->deskripsi }}</p>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('jurusan_id') 
                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Informasi Tambahan --}}
            <div class="p-4 bg-blue-50 rounded-xl border border-blue-200">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-blue-600 text-sm shrink-0 mt-0.5">info</span>
                    <div class="text-xs text-blue-800">
                        <p class="font-semibold mb-1">Informasi:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pilih salah satu jurusan yang tersedia</li>
                            <li>Jurusan yang dipilih tidak dapat diubah setelah pendaftaran dikirim</li>
                            <li>Pastikan Anda memilih jurusan sesuai dengan minat dan kemampuan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="pt-6 lg:pt-8 flex flex-col-reverse sm:flex-row gap-3 lg:gap-4" style="border-top:1px solid #f1f5f9;">
                <a href="{{ route('siswa.pendaftaran.step3') }}"
                    class="sm:flex-1 py-3 lg:py-4 px-6 rounded-xl font-bold text-sm lg:text-base text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                </a>
                <button type="submit"
                    class="sm:flex-[2] py-3 lg:py-4 px-6 rounded-xl font-bold text-sm lg:text-base text-white transition-all flex items-center justify-center gap-2"
                    style="background-color:#018B3E; box-shadow:0 8px 24px rgba(1,139,62,0.25);"
                    onmouseover="this.style.backgroundColor='#016b30';" onmouseout="this.style.backgroundColor='#018B3E';">
                    Lanjut ke Tahap Berikutnya <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateJurusan(input) {
    document.querySelectorAll('.jurusan-label').forEach(label => {
        const r = label.querySelector('input[name="jurusan_id"]');
        if (!r) return;
        label.style.borderColor     = r.checked ? '#018B3E' : '#f1f5f9';
        label.style.backgroundColor = r.checked ? 'rgba(1,139,62,0.05)' : '#f8fafc';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.jurusan-label input:checked').forEach(r => {
        r.closest('.jurusan-label').style.borderColor = '#018B3E';
        r.closest('.jurusan-label').style.backgroundColor = 'rgba(1,139,62,0.05)';
    });
});
</script>
@endpush