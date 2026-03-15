@php $currentStep = $currentStep ?? 1; @endphp

@php
    $stepLabels = [
        1 => ['label' => 'Data Pribadi', 'icon' => 'person'],
        2 => ['label' => 'Sekolah Asal', 'icon' => 'school'],
        3 => ['label' => 'Orang Tua', 'icon' => 'family_restroom'],
        4 => ['label' => 'Jurusan', 'icon' => 'menu_book'],
        5 => ['label' => 'Dokumen', 'icon' => 'folder'],
    ];
    $stepsDone = $currentStep - 1;
@endphp

<div class="mb-8">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        {{-- ── Header Label ─────────────────────────────────── --}}
        <div class="px-5 py-3.5 flex items-center justify-between border-b border-slate-100"
            style="background:rgba(1,139,62,0.03);">
            <div class="flex items-center gap-2.5">
                <div class="size-7 rounded-lg flex items-center justify-center" style="background:rgba(1,139,62,0.1);">
                    <span class="material-symbols-outlined text-sm" style="color:#018B3E;">edit_note</span>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-700 leading-tight">Alur Pengisian Formulir Pendaftaran</p>
                    <p class="text-[10px] text-slate-400 leading-tight mt-0.5">
                        Lengkapi setiap langkah secara berurutan
                    </p>
                </div>
            </div>
            {{-- Progress badge --}}
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full" style="background:rgba(1,139,62,0.08);">
                <span class="text-xs font-black" style="color:#018B3E;">{{ $stepsDone }}/5</span>
                <span class="text-[10px] font-semibold text-slate-400">selesai</span>
            </div>
        </div>

        {{-- ── Stepper ───────────────────────────────────────── --}}
        <div class="px-4 sm:px-6 py-5">
            <div class="flex items-start w-full">

                @foreach($stepLabels as $num => $step)
                            @php
                                $done = $num < $currentStep;
                                $active = $num === $currentStep;
                            @endphp

                            {{-- Step Item --}}
                            <div class="flex flex-col items-center gap-2" style="flex:0 0 auto; width:60px;">

                                {{-- Circle --}}
                                <div class="flex items-center justify-center rounded-full transition-all" style="
                                        width:38px; height:38px; flex-shrink:0;
                                        {{ $done
                    ? 'background:#018B3E; box-shadow:0 0 0 3px rgba(1,139,62,0.15);'
                    : ($active
                        ? 'background:#018B3E; box-shadow:0 0 0 4px rgba(1,139,62,0.2), 0 4px 14px rgba(1,139,62,0.35);'
                        : 'background:#f8fafc; border:2px solid #e2e8f0;')
                                        }}
                                    ">
                                    @if($done)
                                        <span class="material-symbols-outlined"
                                            style="font-size:18px; color:white; font-variation-settings:'FILL' 1;">check</span>
                                    @elseif($active)
                                        <span class="material-symbols-outlined"
                                            style="font-size:18px; color:white; font-variation-settings:'FILL' 1;">{{ $step['icon'] }}</span>
                                    @else
                                        <span style="font-size:12px; font-weight:800; color:#cbd5e1;">{{ $num }}</span>
                                    @endif
                                </div>

                                {{-- Label --}}
                                <span class="text-center leading-tight" style="
                                        font-size:10px;
                                        font-weight:{{ $active ? '800' : '600' }};
                                        color:{{ ($done || $active) ? '#018B3E' : '#cbd5e1' }};
                                        overflow-wrap:break-word;
                                        word-break:break-word;
                                        max-width:60px;
                                    ">
                                    {{ $step['label'] }}
                                </span>

                            </div>

                            {{-- Connector Line --}}
                            @if($num < 5)
                                <div style="
                                    flex:1;
                                    height:2px;
                                    margin-top:18px;
                                    border-radius:999px;
                                    min-width:8px;
                                    background:{{ $done ? '#018B3E' : 'rgba(1,139,62,0.12)' }};
                                "></div>
                            @endif

                @endforeach

            </div>
        </div>

    </div>
</div>