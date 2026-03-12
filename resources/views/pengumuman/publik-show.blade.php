{{-- resources/views/pengumuman/publik-show.blade.php --}}
@extends('layouts.app')

@section('title', $pengumuman->judul . ' - Pengumuman PPDB SMK NU II Medan')

@section('content')
    <div class="relative flex min-h-screen flex-col overflow-x-hidden">
        @include('partials.navbar')

        <main class="flex-1" style="background-color: #F6F4F7;">

            {{-- ================================================================
            HERO SECTION (MENGIKUTI STYLE PUBLIK)
            ================================================================ --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                <div class="relative rounded-3xl overflow-hidden min-h-[280px] flex flex-col justify-end shadow-2xl"
                    style="background: linear-gradient(135deg, #018B3E, #016b30);">

                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 z-10"
                        style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);">
                    </div>

                    {{-- Background pattern --}}
                    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width="
                        60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg" %3E%3Cg fill="none"
                        fill-rule="evenodd" %3E%3Cg fill="%23ffffff" fill-opacity="0.4" %3E%3Cpath
                        d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"
                        /%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;"></div>

                    {{-- Content --}}
                    <div class="relative z-20 p-8 md:p-12">
                        {{-- Breadcrumb --}}
                        <nav class="flex items-center gap-2 text-xs mb-6 text-white/60">
                            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                            <a href="{{ route('pengumuman.publik') }}"
                                class="hover:text-white transition-colors">Pengumuman</a>
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                            <span
                                class="text-white/90 truncate max-w-[200px]">{{ Str::limit($pengumuman->judul, 40) }}</span>
                        </nav>

                        <span
                            class="inline-block px-4 py-1.5 rounded-full text-white text-xs font-bold uppercase tracking-wider mb-4"
                            style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(8px);">
                            Detail Pengumuman
                        </span>

                        <h1 class="text-white text-2xl md:text-4xl lg:text-5xl font-black leading-tight">
                            {{ $pengumuman->judul }}
                        </h1>

                        {{-- Meta info --}}
                        <div class="flex flex-wrap items-center gap-4 mt-5 text-sm text-white/80">
                            @if($pengumuman->createdBy)
                                <span class="flex items-center gap-2">
                                    <span
                                        class="size-6 rounded-full flex items-center justify-center text-white text-[10px] font-bold shrink-0"
                                        style="background-color: rgba(255,255,255,0.2);">
                                        {{ strtoupper(substr($pengumuman->createdBy->nama_lengkap ?? $pengumuman->createdBy->name, 0, 2)) }}
                                    </span>
                                    {{ $pengumuman->createdBy->nama_lengkap ?? $pengumuman->createdBy->name }}
                                </span>
                            @endif
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">calendar_today</span>
                                {{ \Carbon\Carbon::parse($pengumuman->tanggal_publish ?? $pengumuman->created_at)->translatedFormat('d F Y') }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">schedule</span>
                                {{ \Carbon\Carbon::parse($pengumuman->tanggal_publish ?? $pengumuman->created_at)->format('H:i') }}
                                WIB
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================
            CONTENT AREA
            ================================================================ --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

                {{-- Artikel utama --}}
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-200"
                    style="box-shadow: 0 4px 24px rgba(0,0,0,0.06);">

                    {{-- Garis aksen atas --}}
                    <div class="h-1 w-full" style="background: linear-gradient(90deg, #018B3E, #F6CB04);"></div>

                    {{-- Isi pengumuman --}}
                    <div class="p-6 md:p-10 lg:p-12">
                        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed"
                            style="font-size: 1rem; line-height: 1.8;">
                            {!! $pengumuman->isi !!}
                        </div>
                    </div>

                    {{-- Footer artikel --}}
                    <div class="px-6 md:px-10 py-5 border-t border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3"
                        style="background-color: #f8fafc;">
                        <div class="flex items-center gap-3 text-xs text-slate-500">
                            <span class="material-symbols-outlined text-base" style="color: #018B3E;">verified</span>
                            <span>Dikeluarkan oleh <strong class="text-slate-700">Panitia PPDB SMK NU II
                                    Medan</strong></span>
                        </div>
                        @if($pengumuman->createdBy)
                            <span class="text-xs text-slate-400">
                                Ditulis oleh {{ $pengumuman->createdBy->nama_lengkap ?? $pengumuman->createdBy->name }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Navigasi bawah --}}
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <a href="{{ route('pengumuman.publik') }}"
                        class="flex-1 flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl font-bold text-sm transition-all border-2"
                        style="border-color: rgba(1,139,62,0.2); color: #018B3E;"
                        onmouseover="this.style.backgroundColor='rgba(1,139,62,0.05)';"
                        onmouseout="this.style.backgroundColor='transparent';">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Kembali ke Daftar Pengumuman
                    </a>
                    @guest
                        <a href="{{ route('register') }}"
                            class="flex-1 flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl font-bold text-sm text-white transition-all"
                            style="background-color: #018B3E; box-shadow: 0 8px 20px rgba(1,139,62,0.25);"
                            onmouseover="this.style.backgroundColor='#016b30';"
                            onmouseout="this.style.backgroundColor='#018B3E';">
                            <span class="material-symbols-outlined">how_to_reg</span>
                            Daftar Sekarang
                        </a>
                    @endguest
                </div>

                {{-- Info kontak --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 flex items-start gap-4 mt-8"
                    style="box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                    <div class="size-10 rounded-xl flex items-center justify-center shrink-0 text-white"
                        style="background-color: #018B3E;">
                        <span class="material-symbols-outlined text-base">support_agent</span>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm">Ada pertanyaan seputar pengumuman ini?</p>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Hubungi panitia PPDB SMK NU II Medan melalui WhatsApp Center atau datang langsung ke
                            sekretariat.
                        </p>
                        <a href="#" class="mt-2 inline-flex items-center gap-1.5 text-xs font-bold" style="color: #018B3E;">
                            <span class="material-symbols-outlined text-sm">chat</span>
                            WhatsApp Center
                        </a>
                    </div>
                </div>

            </div>
        </main>

        @include('partials.footer')
    </div>

    @push('styles')
        <style>
            /* Styling untuk konten rich text */
            .prose h1,
            .prose h2,
            .prose h3 {
                color: #0f2318;
                margin-top: 1.5em;
                margin-bottom: 0.75em;
            }

            .prose h2 {
                font-size: 1.5rem;
                font-weight: 700;
            }

            .prose h3 {
                font-size: 1.25rem;
                font-weight: 600;
            }

            .prose p {
                margin-bottom: 1.25em;
                color: #334155;
            }

            .prose a {
                color: #018B3E;
                text-decoration: underline;
                text-underline-offset: 2px;
            }

            .prose a:hover {
                color: #016b30;
            }

            .prose ul,
            .prose ol {
                margin: 1em 0;
                padding-left: 1.5em;
            }

            .prose li {
                margin-bottom: 0.5em;
                color: #334155;
            }

            .prose blockquote {
                border-left: 4px solid #018B3E;
                background-color: #f8fafc;
                padding: 1em 1.5em;
                font-style: italic;
                margin: 1.5em 0;
                border-radius: 0 12px 12px 0;
            }

            .prose img {
                border-radius: 12px;
                max-width: 100%;
                height: auto;
                margin: 1.5em 0;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            }

            .prose table {
                width: 100%;
                border-collapse: collapse;
                margin: 1.5em 0;
            }

            .prose th {
                background-color: rgba(1, 139, 62, 0.08);
                font-weight: 600;
                padding: 0.75em;
                border: 1px solid #e2e8f0;
            }

            .prose td {
                padding: 0.75em;
                border: 1px solid #e2e8f0;
            }

            .prose code {
                background-color: #f1f5f9;
                padding: 0.2em 0.4em;
                border-radius: 4px;
                font-size: 0.9em;
                color: #018B3E;
            }

            .prose pre {
                background-color: #1e293b;
                color: #e2e8f0;
                padding: 1em;
                border-radius: 12px;
                overflow-x: auto;
                margin: 1.5em 0;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Smooth scroll untuk anchor links (jika ada)
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        </script>
    @endpush

@endsection