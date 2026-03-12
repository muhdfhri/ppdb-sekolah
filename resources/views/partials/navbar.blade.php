{{-- resources/views/partials/navbar.blade.php --}}
{{-- Tailwind CSS 4 + DaisyUI 5 --}}

{{-- Kompensasi tinggi navbar fixed agar konten tidak tertutup --}}
<style>
    body>*:not(.drawer),
    .drawer>.drawer-content>*:not(header) {
        /* tidak perlu, pakai cara lain di bawah */
    }

    /* Tambahkan padding-top ke elemen pertama setelah navbar */
    .navbar-spacer {
        height: 64px;
    }

    @media (min-width: 640px) {
        .navbar-spacer {
            height: 80px;
        }
    }
</style>

<div class="drawer drawer-end">
    <input id="mobile-drawer" type="checkbox" class="drawer-toggle" />

    <div class="drawer-content flex flex-col">

        {{-- ============================================================
        NAVBAR
        ============================================================ --}}
        <header id="main-navbar" class="fixed top-0 left-0 right-0 z-50 w-full"
            style="background-color: #018B3E; color: white; box-shadow: 0 2px 16px rgba(0,0,0,0.12);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">

                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="size-10 rounded-full flex items-center justify-center p-0.5 overflow-hidden"
                            style="background-color: white;">
                            <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
                                class="w-full h-full object-contain rounded-full">
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-sm sm:text-lg font-bold leading-tight tracking-tight uppercase">
                                SMK NU II Medan
                            </h2>
                            <span class="text-[10px] opacity-75">Mencetak Generasi Unggul & Islami</span>
                        </div>
                    </a>

                    {{-- Desktop Nav Links --}}
                    <nav class="hidden md:flex items-center gap-8">
                        <a href="#beranda" class="text-sm font-medium transition-colors" style="color: white;"
                            onmouseover="this.style.color='#F6CB04';" onmouseout="this.style.color='white';">
                            Beranda
                        </a>
                        <a href="#tentang" class="text-sm font-medium transition-colors" style="color: white;"
                            onmouseover="this.style.color='#F6CB04';" onmouseout="this.style.color='white';">
                            Tentang
                        </a>

                        {{-- ── DROPDOWN: Alur PPDB ── --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center gap-1 text-sm font-medium transition-colors"
                                style="color: white;" onmouseover="this.style.color='#F6CB04';"
                                onmouseout="this.style.color='white';">
                                Alur PPDB
                                <span class="material-symbols-outlined text-base transition-transform duration-200"
                                    :style="open ? 'transform: rotate(180deg)' : ''">
                                    expand_more
                                </span>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 mt-3 w-52 rounded-2xl overflow-hidden"
                                style="background-color: white; box-shadow: 0 20px 60px rgba(0,0,0,0.15); border: 1px solid rgba(1,139,62,0.1); top: 100%;">

                                {{-- Alur PPDB (anchor) --}}
                                <a href="#alur" @click="open = false"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold transition-colors"
                                    style="color: #018B3E;"
                                    onmouseover="this.style.backgroundColor='rgba(1,139,62,0.07)';"
                                    onmouseout="this.style.backgroundColor='transparent';">
                                    <span class="material-symbols-outlined text-base">route</span>
                                    Alur Pendaftaran
                                </a>

                                <div style="height: 1px; background-color: #f1f5f9; margin: 0 16px;"></div>

                                {{-- Pengumuman --}}
                                <a href="{{ route('pengumuman.publik') }}" @click="open = false"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold transition-colors"
                                    style="color: #334155;"
                                    onmouseover="this.style.backgroundColor='rgba(1,139,62,0.07)'; this.style.color='#018B3E';"
                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#334155';">
                                    <span class="material-symbols-outlined text-base">campaign</span>
                                    Pengumuman
                                </a>

                            </div>
                        </div>
                        {{-- ── END DROPDOWN ── --}}

                        <a href="#syarat" class="text-sm font-medium transition-colors" style="color: white;"
                            onmouseover="this.style.color='#F6CB04';" onmouseout="this.style.color='white';">
                            Syarat
                        </a>
                        <a href="#faq" class="text-sm font-medium transition-colors" style="color: white;"
                            onmouseover="this.style.color='#F6CB04';" onmouseout="this.style.color='white';">
                            FAQ
                        </a>
                    </nav>

                    {{-- CTA Area --}}
                    <div class="flex items-center gap-3">

                        @auth
                            {{-- ── USER LOGGED IN: Avatar + Dropdown ── --}}
                            @php
                                $user = Auth::user();
                                $initials = collect(explode(' ', $user->nama_lengkap ?? $user->name))
                                    ->map(fn($w) => strtoupper($w[0]))
                                    ->take(2)
                                    ->join('');
                                $dashboard = $user->isAdmin()
                                    ? route('admin.dashboard')
                                    : route('siswa.dashboard');
                                $dashLabel = $user->isAdmin() ? 'Panel Admin' : 'Dashboard Saya';
                                $dashIcon = $user->isAdmin() ? 'admin_panel_settings' : 'dashboard';
                            @endphp

                            {{-- Desktop Dropdown --}}
                            <div class="hidden md:block relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.outside="open = false"
                                    class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl transition-all"
                                    style="background-color: rgba(255,255,255,0.12);"
                                    onmouseover="this.style.backgroundColor='rgba(255,255,255,0.2)';"
                                    onmouseout="this.style.backgroundColor='rgba(255,255,255,0.12)';">

                                    <div class="size-8 rounded-full font-black text-xs flex items-center justify-center shrink-0"
                                        style="background-color: #F6CB04; color: #0f2318;">
                                        {{ $initials }}
                                    </div>

                                    <div class="flex flex-col text-left leading-tight">
                                        <span class="text-sm font-bold text-white truncate max-w-[120px]">
                                            {{ Str::limit($user->nama_lengkap ?? $user->name, 18) }}
                                        </span>
                                        <span class="text-[10px] font-medium" style="color: rgba(246,203,4,0.85);">
                                            {{ $user->isAdmin() ? 'Administrator' : 'Calon Siswa' }}
                                        </span>
                                    </div>

                                    <span class="material-symbols-outlined text-sm text-white/70"
                                        style="transition: transform 0.2s;"
                                        :style="open ? 'transform: rotate(180deg)' : ''">
                                        expand_more
                                    </span>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-56 rounded-2xl overflow-hidden"
                                    style="background-color: white; box-shadow: 0 20px 60px rgba(0,0,0,0.15); border: 1px solid rgba(1,139,62,0.1); top: 100%;">

                                    <div class="px-4 py-3 border-b"
                                        style="border-color: #f1f5f9; background-color: rgba(1,139,62,0.03);">
                                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Login
                                            sebagai</p>
                                        <p class="text-sm font-bold text-slate-800 mt-0.5 truncate">
                                            {{ $user->nama_lengkap ?? $user->name }}
                                        </p>
                                        <p class="text-xs text-slate-400 truncate">{{ $user->email }}</p>
                                    </div>

                                    <div class="py-2">
                                        <a href="{{ $dashboard }}"
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold transition-colors"
                                            style="color: #018B3E;"
                                            onmouseover="this.style.backgroundColor='rgba(1,139,62,0.07)';"
                                            onmouseout="this.style.backgroundColor='transparent';">
                                            <span class="material-symbols-outlined text-base">{{ $dashIcon }}</span>
                                            {{ $dashLabel }}
                                        </a>

                                        @if(!$user->isAdmin())
                                            <a href="{{ route('siswa.pendaftaran.index') }}"
                                                class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold transition-colors text-slate-600"
                                                onmouseover="this.style.backgroundColor='rgba(0,0,0,0.04)';"
                                                onmouseout="this.style.backgroundColor='transparent';">
                                                <span class="material-symbols-outlined text-base">assignment</span>
                                                Status Pendaftaran
                                            </a>
                                            <a href="{{ route('siswa.profil') }}"
                                                class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold transition-colors text-slate-600"
                                                onmouseover="this.style.backgroundColor='rgba(0,0,0,0.04)';"
                                                onmouseout="this.style.backgroundColor='transparent';">
                                                <span class="material-symbols-outlined text-base">manage_accounts</span>
                                                Profil Saya
                                            </a>
                                        @endif
                                    </div>

                                    <div class="border-t py-2" style="border-color: #f1f5f9;">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold transition-colors text-red-500"
                                                onmouseover="this.style.backgroundColor='rgba(239,68,68,0.07)';"
                                                onmouseout="this.style.backgroundColor='transparent';">
                                                <span class="material-symbols-outlined text-base">logout</span>
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @else
                            <a href="{{ route('register') }}"
                                class="hidden sm:flex px-5 py-2 rounded-lg font-bold text-sm transition-all shadow-sm hover:brightness-110"
                                style="background-color: #F6CB04; color: #0f2318;">
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('login') }}"
                                class="hidden sm:flex px-4 py-2 rounded-lg font-bold text-sm border transition-all"
                                style="border-color: rgba(255,255,255,0.4); color: white;"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.12)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                Masuk
                            </a>
                        @endauth

                        {{-- Hamburger (mobile) --}}
                        <label for="mobile-drawer" class="md:hidden btn btn-ghost btn-sm p-1" style="color: white;">
                            <span class="material-symbols-outlined text-2xl">menu</span>
                        </label>

                    </div>
                </div>
            </div>
        </header>
        {{-- Spacer untuk kompensasi navbar fixed --}}
        <div class="navbar-spacer"></div>
    </div>

    {{-- ============================================================
    DRAWER SIDE (Mobile Menu)
    ============================================================ --}}
    <div class="drawer-side z-[60]">
        <label for="mobile-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

        <div class="min-h-full w-72 flex flex-col" style="background-color: #0f2318;">

            {{-- Drawer Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b"
                style="border-color: rgba(255,255,255,0.08);">
                <div class="flex items-center gap-3">
                    <div class="size-9 rounded-full flex items-center justify-center"
                        style="background-color: #018B3E;">
                        <span class="material-symbols-outlined text-white text-xl">school</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white uppercase leading-tight">SMK NU II Medan</p>
                        <p class="text-[10px] opacity-60 text-white">Generasi Unggul & Islami</p>
                    </div>
                </div>
                <label for="mobile-drawer" class="btn btn-ghost btn-sm p-1" style="color: rgba(255,255,255,0.6);">
                    <span class="material-symbols-outlined">close</span>
                </label>
            </div>

            @auth
                @php
                    $user = Auth::user();
                    $initials = collect(explode(' ', $user->nama_lengkap ?? $user->name))
                        ->map(fn($w) => strtoupper($w[0]))->take(2)->join('');
                    $dashboard = $user->isAdmin() ? route('admin.dashboard') : route('siswa.dashboard');
                    $dashLabel = $user->isAdmin() ? 'Panel Admin' : 'Dashboard Saya';
                    $dashIcon = $user->isAdmin() ? 'admin_panel_settings' : 'dashboard';
                @endphp
                <div class="mx-4 mt-5 rounded-2xl p-4"
                    style="background-color: rgba(1,139,62,0.2); border: 1px solid rgba(1,139,62,0.3);">
                    <div class="flex items-center gap-3">
                        <div class="size-10 rounded-full font-black text-sm flex items-center justify-center shrink-0"
                            style="background-color: #F6CB04; color: #0f2318;">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-white truncate">{{ $user->nama_lengkap ?? $user->name }}</p>
                            <p class="text-xs truncate" style="color: rgba(246,203,4,0.85);">
                                {{ $user->isAdmin() ? 'Administrator' : 'Calon Siswa' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endauth

            {{-- Nav Links --}}
            <nav class="flex flex-col px-4 py-4 gap-1 flex-1">
                <a href="#beranda" onclick="document.getElementById('mobile-drawer').checked = false;"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                    style="color: rgba(255,255,255,0.75);"
                    onmouseover="this.style.backgroundColor='rgba(1,139,62,0.25)'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.75)';">
                    <span class="material-symbols-outlined text-xl" style="color: #018B3E;">home</span>
                    Beranda
                </a>
                <a href="#tentang" onclick="document.getElementById('mobile-drawer').checked = false;"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                    style="color: rgba(255,255,255,0.75);"
                    onmouseover="this.style.backgroundColor='rgba(1,139,62,0.25)'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.75)';">
                    <span class="material-symbols-outlined text-xl" style="color: #018B3E;">info</span>
                    Tentang
                </a>

                {{-- ── MOBILE: Alur PPDB group dengan Pengumuman ── --}}
                <div x-data="{ openAlur: false }">
                    <button @click="openAlur = !openAlur"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                        style="color: rgba(255,255,255,0.75);"
                        onmouseover="this.style.backgroundColor='rgba(1,139,62,0.25)'; this.style.color='white';"
                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.75)';">
                        <span class="material-symbols-outlined text-xl" style="color: #018B3E;">route</span>
                        <span class="flex-1 text-left">Alur PPDB</span>
                        <span class="material-symbols-outlined text-base transition-transform duration-200"
                            :style="openAlur ? 'transform: rotate(180deg)' : ''" style="color: rgba(255,255,255,0.4);">
                            expand_more
                        </span>
                    </button>

                    {{-- Sub-items --}}
                    <div x-show="openAlur" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 pl-4 mt-1 space-y-1 border-l"
                        style="border-color: rgba(1,139,62,0.3);">

                        <a href="#alur"
                            onclick="openAlur = false; document.getElementById('mobile-drawer').checked = false;"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all"
                            style="color: rgba(255,255,255,0.65);"
                            onmouseover="this.style.backgroundColor='rgba(1,139,62,0.2)'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.65)';">
                            <span class="material-symbols-outlined text-base" style="color: #018B3E;">route</span>
                            Alur Pendaftaran
                        </a>

                        <a href="{{ route('pengumuman.publik') }}"
                            onclick="document.getElementById('mobile-drawer').checked = false;"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all"
                            style="color: rgba(255,255,255,0.65);"
                            onmouseover="this.style.backgroundColor='rgba(1,139,62,0.2)'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.65)';">
                            <span class="material-symbols-outlined text-base" style="color: #018B3E;">campaign</span>
                            Pengumuman
                        </a>
                    </div>
                </div>
                {{-- ── END MOBILE ALUR DROPDOWN ── --}}

                <a href="#syarat" onclick="document.getElementById('mobile-drawer').checked = false;"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                    style="color: rgba(255,255,255,0.75);"
                    onmouseover="this.style.backgroundColor='rgba(1,139,62,0.25)'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.75)';">
                    <span class="material-symbols-outlined text-xl" style="color: #018B3E;">checklist</span>
                    Syarat
                </a>
                <a href="#faq" onclick="document.getElementById('mobile-drawer').checked = false;"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                    style="color: rgba(255,255,255,0.75);"
                    onmouseover="this.style.backgroundColor='rgba(1,139,62,0.25)'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.75)';">
                    <span class="material-symbols-outlined text-xl" style="color: #018B3E;">help</span>
                    FAQ
                </a>

                @auth
                    <div class="mt-3 pt-3 border-t" style="border-color: rgba(255,255,255,0.08);">
                        <p class="text-[10px] font-bold uppercase tracking-widest px-4 mb-2"
                            style="color: rgba(255,255,255,0.35);">Akun Saya</p>
                        <a href="{{ $dashboard }}" onclick="document.getElementById('mobile-drawer').checked = false;"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all"
                            style="color: #F6CB04; background-color: rgba(246,203,4,0.08);"
                            onmouseover="this.style.backgroundColor='rgba(246,203,4,0.16)';"
                            onmouseout="this.style.backgroundColor='rgba(246,203,4,0.08)';">
                            <span class="material-symbols-outlined text-xl" style="color: #F6CB04;">{{ $dashIcon }}</span>
                            {{ $dashLabel }}
                        </a>
                        @if(!Auth::user()->isAdmin())
                            <a href="{{ route('siswa.pendaftaran.index') }}"
                                onclick="document.getElementById('mobile-drawer').checked = false;"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                                style="color: rgba(255,255,255,0.75);"
                                onmouseover="this.style.backgroundColor='rgba(1,139,62,0.25)'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.75)';">
                                <span class="material-symbols-outlined text-xl" style="color: #018B3E;">assignment</span>
                                Status Pendaftaran
                            </a>
                        @endif
                    </div>
                @endauth
            </nav>

            {{-- Drawer CTA / Logout --}}
            <div class="px-4 pb-8 pt-2 border-t" style="border-color: rgba(255,255,255,0.08);">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold text-sm transition-all"
                            style="background-color: rgba(239,68,68,0.15); color: #fca5a5; border: 1.5px solid rgba(239,68,68,0.25);"
                            onmouseover="this.style.backgroundColor='rgba(239,68,68,0.25)';"
                            onmouseout="this.style.backgroundColor='rgba(239,68,68,0.15)';">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                            Keluar dari Akun
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}"
                        class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold text-sm transition-all hover:brightness-110"
                        style="background-color: #F6CB04; color: #0f2318;">
                        <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-bold text-sm mt-3 transition-all"
                        style="border: 1.5px solid rgba(1,139,62,0.5); color: rgba(255,255,255,0.75);"
                        onmouseover="this.style.borderColor='#018B3E'; this.style.color='white';"
                        onmouseout="this.style.borderColor='rgba(1,139,62,0.5)'; this.style.color='rgba(255,255,255,0.75)';">
                        <span class="material-symbols-outlined text-[20px]">login</span>
                        Login
                    </a>
                @endauth
            </div>

        </div>
    </div>
</div>