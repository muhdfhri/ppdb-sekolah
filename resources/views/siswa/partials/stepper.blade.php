{{-- resources/views/siswa/pendaftaran/partials/stepper.blade.php --}}
{{--
CARA PAKAI:
@include('siswa.pendaftaran.partials.stepper', ['currentStep' => 1])

Selalu pass $currentStep sebagai parameter eksplisit di @include,
BUKAN mengandalkan variabel dari scope parent.
--}}
@php $currentStep = $currentStep ?? 1; @endphp

<div class="mb-8 overflow-x-auto pb-4">
    <div class="flex justify-between items-start min-w-[600px] px-2">
        @php
            $stepLabels = ['Data Pribadi', 'Sekolah Asal', 'Orang Tua', 'Jurusan', 'Dokumen'];
        @endphp

        @foreach($stepLabels as $i => $label)
            @php
                $num = $i + 1;
                $done = $num < $currentStep;
                $active = $num === $currentStep;
            @endphp

            <div class="flex flex-col items-center gap-2">
                <div class="size-10 rounded-full font-bold flex items-center justify-center transition-all" style="{{ $done || $active
            ? 'background-color:#018B3E; color:white; box-shadow:0 4px 12px rgba(1,139,62,0.3);'
            : 'background-color:white; border:2px solid rgba(1,139,62,0.2); color:#94a3b8;' }}">
                    @if($done)
                        <span class="material-symbols-outlined text-base">check</span>
                    @else
                        {{ $num }}
                    @endif
                </div>
                <span class="text-xs font-{{ $active ? 'bold' : 'medium' }}"
                    style="color:{{ $active || $done ? '#018B3E' : '#94a3b8' }};">
                    {{ $label }}
                </span>
            </div>

            @if($i < 4)
                <div class="flex-1 h-[2px] mt-5 mx-2 rounded-full"
                    style="background-color:{{ $done ? '#018B3E' : 'rgba(1,139,62,0.15)' }};"></div>
            @endif
        @endforeach
    </div>
</div>