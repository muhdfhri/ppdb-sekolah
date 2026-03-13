{{-- resources/views/404.blade.php --}}
@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
    <div class="min-h-screen bg-[#F6F4F7] font-['Public Sans'] flex items-center justify-center p-4">

        {{-- Decorative blobs --}}
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl opacity-10 pointer-events-none"
            style="background-color: #018B3E;"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full blur-3xl opacity-10 pointer-events-none"
            style="background-color: #F6CB04;"></div>

        <div class="max-w-2xl w-full text-center relative z-10">

            {{-- Icon 404 --}}
            <div class="mb-8 relative">
                <div class="text-[150px] font-black text-[#018B3E] opacity-20 leading-none">404</div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="material-symbols-outlined text-8xl text-[#018B3E]" style="font-size: 120px;">error</span>
                </div>
            </div>

            {{-- Title --}}
            <h1 class="text-3xl md:text-4xl font-black text-[#0f2318] mb-4">
                Halaman Tidak Ditemukan
            </h1>

            {{-- Description --}}
            <p class="text-[#3a5a46] text-lg mb-8 max-w-md mx-auto">
                Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.
            </p>

            {{-- Navigation Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#018B3E] text-white font-bold rounded-xl hover:bg-[#016b30] transition-all shadow-lg">
                    <span class="material-symbols-outlined">home</span>
                    Kembali ke Beranda
                </a>

                <a href="javascript:history.back()"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-[#018B3E] text-[#018B3E] font-bold rounded-xl hover:bg-[#018B3E] hover:text-white transition-all">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Kembali
                </a>
            </div>

            {{-- Quick Links --}}
            <div class="mt-8 flex flex-wrap justify-center gap-4 text-sm">
                <a href="{{ route('pengumuman.publik') }}" class="text-[#018B3E] hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">campaign</span>
                    Pengumuman
                </a>
                @auth
                    @if(auth()->user()->role === 'siswa')
                        <a href="{{ route('siswa.dashboard') }}" class="text-[#018B3E] hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-base">dashboard</span>
                            Dashboard Siswa
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-[#018B3E] hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-base">admin_panel_settings</span>
                            Dashboard Admin
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-[#018B3E] hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">login</span>
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="text-[#018B3E] hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">how_to_reg</span>
                        Daftar
                    </a>
                @endauth
            </div>

            {{-- Help Text --}}
            <div class="mt-12 text-sm text-[#3a5a46]">
                <p>Jika Anda merasa ini adalah kesalahan, silakan hubungi admin.</p>
                <div class="flex justify-center gap-4 mt-4">
                    <a href="https://wa.me/6281266857686?text={{ urlencode('Halo admin, saya mengalami kendala akses halaman di website PPDB. Mohon bantuannya.') }}"
                        target="_blank" class="inline-flex items-center gap-1 text-[#018B3E] hover:underline">
                        <span class="material-symbols-outlined text-base">chat</span>
                        WhatsApp Admin
                    </a>
                    <span class="text-[#3a5a46]">|</span>
                    <a href="mailto:info@smknu2medan.sch.id"
                        class="inline-flex items-center gap-1 text-[#018B3E] hover:underline">
                        <span class="material-symbols-outlined text-base">mail</span>
                        Email
                    </a>
                </div>
            </div>

            {{-- Status Code --}}
            <div class="mt-8 text-xs text-[#3a5a46] opacity-50">
                Error 404 - Page Not Found
            </div>
        </div>
    </div>
@endsection