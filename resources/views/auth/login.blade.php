@extends('layouts.app')

@section('title', 'Login - PPDB SMK NU II Medan')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4" style="background-color: #F6F4F7;">

        <div class="w-full max-w-md bg-white rounded-xl overflow-hidden"
            style="box-shadow: 0 20px 60px rgba(1,139,62,0.10); border: 1px solid rgba(1,139,62,0.12);">

            {{-- Hero Header in Card --}}
            <a href="{{ url('/') }}" class="block">
                <div class="relative h-28 w-full overflow-hidden" style="background-color: rgba(1,139,62,0.1);">
                    <div class="absolute inset-0"
                        style="background: linear-gradient(135deg, rgba(1,139,62,0.2), transparent);">
                    </div>
                    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                        <div class="bg-white p-3 rounded-full shadow-md mb-2 overflow-hidden">
                            <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
                                class="w-10 h-10 object-cover rounded-full">
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-16"
                        style="background: linear-gradient(to top, white, transparent);"></div>
                </div>
            </a>

            <div class="px-8 pb-8 pt-4">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold" style="color: #0f2318;">Login PPDB</h1>
                    <p class="text-sm mt-1" style="color: #3a5a46;">Masuk ke akun Anda</p>
                </div>

                {{-- Simple Error Alert --}}
                @if($errors->any())
                    <div class="mb-4 p-4 rounded-lg text-sm" role="alert" 
                        style="background-color: #FEF2F2; border: 1px solid #FEE2E2; color: #991B1B;">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">error</span>
                            <span class="font-medium">{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                {{-- Success Message (untuk notifikasi seperti logout) --}}
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg text-sm" role="alert"
                        style="background-color: #F0FDF4; border: 1px solid #DCFCE7; color: #166534;">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">check_circle</span>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">mail</span>
                            <input 
                                class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all"
                                style="background-color: #F6F4F7; border: 1.5px solid {{ $errors->has('email') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}; color: #0f2318;"
                                onfocus="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#018B3E' }}'"
                                onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}'"
                                placeholder="admin@smknu2medan.sch.id" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                autofocus>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">lock</span>
                            <input 
                                class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all"
                                style="background-color: #F6F4F7; border: 1.5px solid {{ $errors->has('password') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}; color: #0f2318;"
                                onfocus="this.style.borderColor='{{ $errors->has('password') ? '#ef4444' : '#018B3E' }}'"
                                onblur="this.style.borderColor='{{ $errors->has('password') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}'"
                                placeholder="••••••••" 
                                type="password" 
                                name="password" 
                                required>
                        </div>
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" 
                                class="w-4 h-4 rounded" 
                                name="remember"
                                style="accent-color: #018B3E; border: 1.5px solid rgba(1,139,62,0.3);"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="text-sm" style="color: #3a5a46;">Ingat saya</span>
                        </label>
                        {{-- <a href="#" class="text-sm font-medium hover:underline" style="color: #018B3E;">Lupa password?</a> --}}
                    </div>

                    {{-- Submit --}}
                    <button
                        class="w-full font-bold py-3.5 rounded-lg transition-all flex items-center justify-center gap-2 mt-2"
                        style="background-color: #018B3E; color: white; box-shadow: 0 4px 15px rgba(1,139,62,0.3);"
                        onmouseover="this.style.backgroundColor='#015f2a';"
                        onmouseout="this.style.backgroundColor='#018B3E';" 
                        type="submit">
                        Masuk
                        <span class="material-symbols-outlined text-[20px]">login</span>
                    </button>
                </form>

                <div class="mt-8 pt-6 text-center" style="border-top: 1px solid rgba(1,139,62,0.1);">
                    <p class="text-sm" style="color: #3a5a46;">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-bold hover:underline ml-1"
                            style="color: #018B3E;">Daftar di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection