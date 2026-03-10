@extends('layouts.app')

@section('title', 'Daftar Akun - PPDB SMK NU II Medan')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8" style="background-color: #F6F4F7;">

        <div class="w-full max-w-md bg-white rounded-xl overflow-hidden"
            style="box-shadow: 0 20px 60px rgba(1,139,62,0.10); border: 1px solid rgba(1,139,62,0.12);">

            {{-- Hero Header in Card --}}
            <div class="relative h-32 w-full overflow-hidden" style="background-color: rgba(1,139,62,0.1);">
                <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(1,139,62,0.2), transparent);">
                </div>
                <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                    <div class="bg-white p-3 rounded-full shadow-md mb-2">
                        <svg class="w-8 h-8" style="color: #018B3E;" fill="none" viewBox="0 0 48 48"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_6_535)">
                                <path clip-rule="evenodd"
                                    d="M47.2426 24L24 47.2426L0.757355 24L24 0.757355L47.2426 24ZM12.2426 21H35.7574L24 9.24264L12.2426 21Z"
                                    fill="currentColor" fill-rule="evenodd"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_6_535">
                                    <rect fill="white" height="48" width="48"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-16"
                    style="background: linear-gradient(to top, white, transparent);"></div>
            </div>

            <div class="px-8 pb-8 pt-4">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold" style="color: #0f2318;">Daftar Akun Baru</h1>
                    <p class="text-sm mt-1" style="color: #3a5a46;">Penerimaan Peserta Didik Baru (PPDB)</p>
                </div>

                <form action="#" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Nama Lengkap</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">person</span>
                            <input class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all"
                                style="background-color: #F6F4F7; border: 1.5px solid rgba(1,139,62,0.2); color: #0f2318;"
                                onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.1)';"
                                onblur="this.style.borderColor='rgba(1,139,62,0.2)'; this.style.boxShadow='none';"
                                placeholder="Masukkan nama sesuai ijazah" type="text" name="nama_lengkap" required>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">mail</span>
                            <input class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all"
                                style="background-color: #F6F4F7; border: 1.5px solid rgba(1,139,62,0.2); color: #0f2318;"
                                onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.1)';"
                                onblur="this.style.borderColor='rgba(1,139,62,0.2)'; this.style.boxShadow='none';"
                                placeholder="contoh@email.com" type="email" name="email" required>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">lock</span>
                            <input class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all"
                                style="background-color: #F6F4F7; border: 1.5px solid rgba(1,139,62,0.2); color: #0f2318;"
                                onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.1)';"
                                onblur="this.style.borderColor='rgba(1,139,62,0.2)'; this.style.boxShadow='none';"
                                placeholder="Min. 8 karakter" type="password" name="password" required>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">lock_reset</span>
                            <input class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all"
                                style="background-color: #F6F4F7; border: 1.5px solid rgba(1,139,62,0.2); color: #0f2318;"
                                onfocus="this.style.borderColor='#018B3E'; this.style.boxShadow='0 0 0 3px rgba(1,139,62,0.1)';"
                                onblur="this.style.borderColor='rgba(1,139,62,0.2)'; this.style.boxShadow='none';"
                                placeholder="Ulangi password Anda" type="password" name="password_confirmation" required>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button
                        class="w-full font-bold py-3.5 rounded-lg transition-all flex items-center justify-center gap-2 mt-2"
                        style="background-color: #F6CB04; color: #0f2318; box-shadow: 0 4px 15px rgba(246,203,4,0.35);"
                        onmouseover="this.style.filter='brightness(1.05)';" onmouseout="this.style.filter='none';"
                        type="submit">
                        Daftar Sekarang
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-8 pt-6 text-center" style="border-top: 1px solid rgba(1,139,62,0.1);">
                    <p class="text-sm" style="color: #3a5a46;">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold hover:underline ml-1" style="color: #018B3E;">Login
                            di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection