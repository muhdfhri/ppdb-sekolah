@extends('layouts.app')

@section('title', 'Daftar Akun - PPDB SMK NU II Medan')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8" style="background-color: #F6F4F7;">

        <div class="w-full max-w-md bg-white rounded-xl overflow-hidden"
            style="box-shadow: 0 20px 60px rgba(1,139,62,0.10); border: 1px solid rgba(1,139,62,0.12);">

            {{-- Hero Header in Card --}}
            <a href="{{ url('/') }}" class="block">
                <div class="relative h-32 w-full overflow-hidden" style="background-color: rgba(1,139,62,0.1);">
                    <div class="absolute inset-0"
                        style="background: linear-gradient(135deg, rgba(1,139,62,0.2), transparent);">
                    </div>
                    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                        <div class="bg-white p-3 rounded-full shadow-md mb-2 overflow-hidden">
                            <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
                                class="w-8 h-8 object-cover rounded-full">
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-16"
                        style="background: linear-gradient(to top, white, transparent);"></div>
                </div>
            </a>

            <div class="px-8 pb-8 pt-4">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold" style="color: #0f2318;">Daftar Akun Baru</h1>
                    <p class="text-sm mt-1" style="color: #3a5a46;">Penerimaan Peserta Didik Baru (PPDB)</p>
                </div>

                {{-- Error Alert --}}
                @if($errors->any())
                    <div class="mb-4 p-4 rounded-lg text-sm" role="alert"
                        style="background-color: #FEF2F2; border: 1px solid #FEE2E2; color: #991B1B;">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">error</span>
                            <span class="font-medium">{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Nama Lengkap</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">person</span>
                            <input class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all"
                                style="background-color: #F6F4F7; border: 1.5px solid {{ $errors->has('nama_lengkap') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}; color: #0f2318;"
                                onfocus="this.style.borderColor='{{ $errors->has('nama_lengkap') ? '#ef4444' : '#018B3E' }}'"
                                onblur="this.style.borderColor='{{ $errors->has('nama_lengkap') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}'"
                                placeholder="Masukkan nama sesuai ijazah" type="text" name="nama_lengkap"
                                value="{{ old('nama_lengkap') }}" required>
                        </div>
                        @error('nama_lengkap')
                            <p class="text-xs mt-1 flex items-center gap-1" style="color: #ef4444;">
                                <span class="material-symbols-outlined text-[14px]">info</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">mail</span>
                            <input class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all"
                                style="background-color: #F6F4F7; border: 1.5px solid {{ $errors->has('email') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}; color: #0f2318;"
                                onfocus="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#018B3E' }}'"
                                onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}'"
                                placeholder="contoh@email.com" type="email" name="email" value="{{ old('email') }}"
                                required>
                        </div>
                        @error('email')
                            <p class="text-xs mt-1 flex items-center gap-1" style="color: #ef4444;">
                                <span class="material-symbols-outlined text-[14px]">info</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password with Validator --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">lock</span>
                            <input class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all validator"
                                style="background-color: #F6F4F7; border: 1.5px solid {{ $errors->has('password') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}; color: #0f2318;"
                                onfocus="this.style.borderColor='{{ $errors->has('password') ? '#ef4444' : '#018B3E' }}'"
                                onblur="this.style.borderColor='{{ $errors->has('password') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}'"
                                placeholder="Min. 8 karakter" type="password" name="password" id="password" minlength="8"
                                pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                title="Password harus lebih dari 8 karakter, mengandung huruf kecil dan huruf besar"
                                required>
                        </div>

                        {{-- Password Requirements Hint --}}
                        <div class="mt-2 p-3 rounded-lg text-xs space-y-1"
                            style="background-color: #F8FAFC; border: 1px solid #E2E8F0;">
                            <p class="font-semibold mb-1" style="color: #0f2318;">Password harus memenuhi:</p>
                            <div class="flex items-center gap-2" id="req-length">
                                <span class="material-symbols-outlined text-sm" style="color: #94A3B8;">circle</span>
                                <span style="color: #64748B;">Minimal 8 karakter</span>
                            </div>
                            <div class="flex items-center gap-2" id="req-lowercase">
                                <span class="material-symbols-outlined text-sm" style="color: #94A3B8;">circle</span>
                                <span style="color: #64748B;">Setidaknya 1 huruf kecil</span>
                            </div>
                            <div class="flex items-center gap-2" id="req-uppercase">
                                <span class="material-symbols-outlined text-sm" style="color: #94A3B8;">circle</span>
                                <span style="color: #64748B;">Setidaknya 1 huruf besar</span>
                            </div>
                        </div>

                        @error('password')
                            <p class="text-xs mt-1 flex items-center gap-1" style="color: #ef4444;">
                                <span class="material-symbols-outlined text-[14px]">info</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold ml-1" style="color: #0f2318;">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]"
                                style="color: #018B3E;">lock_reset</span>
                            <input class="w-full pl-10 pr-4 py-3 rounded-lg outline-none transition-all"
                                style="background-color: #F6F4F7; border: 1.5px solid {{ $errors->has('password') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}; color: #0f2318;"
                                onfocus="this.style.borderColor='{{ $errors->has('password') ? '#ef4444' : '#018B3E' }}'"
                                onblur="this.style.borderColor='{{ $errors->has('password') ? '#ef4444' : 'rgba(1,139,62,0.2)' }}'"
                                placeholder="Ulangi password Anda" type="password" name="password_confirmation"
                                id="password_confirmation" required>
                        </div>
                        <div id="password-match" class="text-xs mt-1 hidden">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                <span>Password cocok</span>
                            </span>
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

@push('scripts')
    <script>
        // Real-time password requirement checker
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                const password = this.value;

                // Check length
                const lengthReq = document.getElementById('req-length');
                if (password.length >= 8) {
                    lengthReq.innerHTML = '<span class="material-symbols-outlined text-sm" style="color: #16a34a;">check_circle</span><span style="color: #16a34a;">Minimal 8 karakter</span>';
                } else {
                    lengthReq.innerHTML = '<span class="material-symbols-outlined text-sm" style="color: #94A3B8;">circle</span><span style="color: #64748B;">Minimal 8 karakter</span>';
                }

                // Check lowercase
                const lowercaseReq = document.getElementById('req-lowercase');
                if (/[a-z]/.test(password)) {
                    lowercaseReq.innerHTML = '<span class="material-symbols-outlined text-sm" style="color: #16a34a;">check_circle</span><span style="color: #16a34a;">Setidaknya 1 huruf kecil</span>';
                } else {
                    lowercaseReq.innerHTML = '<span class="material-symbols-outlined text-sm" style="color: #94A3B8;">circle</span><span style="color: #64748B;">Setidaknya 1 huruf kecil</span>';
                }

                // Check uppercase
                const uppercaseReq = document.getElementById('req-uppercase');
                if (/[A-Z]/.test(password)) {
                    uppercaseReq.innerHTML = '<span class="material-symbols-outlined text-sm" style="color: #16a34a;">check_circle</span><span style="color: #16a34a;">Setidaknya 1 huruf besar</span>';
                } else {
                    uppercaseReq.innerHTML = '<span class="material-symbols-outlined text-sm" style="color: #94A3B8;">circle</span><span style="color: #64748B;">Setidaknya 1 huruf besar</span>';
                }

                // Check password match if confirm input has value
                if (confirmInput && confirmInput.value) {
                    checkPasswordMatch();
                }
            });
        }

        // Password match checker
        if (confirmInput) {
            confirmInput.addEventListener('input', checkPasswordMatch);
        }

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            const matchDiv = document.getElementById('password-match');

            if (confirm.length > 0) {
                matchDiv.classList.remove('hidden');
                if (password === confirm) {
                    matchDiv.innerHTML = '<span class="flex items-center gap-1" style="color: #16a34a;"><span class="material-symbols-outlined text-[14px]">check_circle</span><span>Password cocok</span></span>';
                } else {
                    matchDiv.innerHTML = '<span class="flex items-center gap-1" style="color: #ef4444;"><span class="material-symbols-outlined text-[14px]">error</span><span>✗ Password tidak cocok</span></span>';
                }
            } else {
                matchDiv.classList.add('hidden');
            }
        }

        // Check on page load if there are old values
        document.addEventListener('DOMContentLoaded', function () {
            if (passwordInput && passwordInput.value) {
                passwordInput.dispatchEvent(new Event('input'));
            }
            if (confirmInput && confirmInput.value) {
                confirmInput.dispatchEvent(new Event('input'));
            }
        });
    </script>
@endpush