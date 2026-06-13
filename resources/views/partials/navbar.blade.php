{{-- resources/views/partials/navbar.blade.php --}}
{{-- Tailwind CSS 4 + DaisyUI 5 --}}

<header id="main-navbar" class="sticky top-0 z-50 w-full" x-data="{ mobileMenuOpen: false }"
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
                    <h2 class="text-sm sm:text-lg font-bold leading-tight tracking-tight uppercase text-white">SMK NU II
                        Medan</h2>
                    <span class="text-[10px] text-white opacity-75">Mencetak Generasi Unggul & Islami</span>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}#beranda"
                    class="text-sm font-medium text-white transition-colors hover:text-[#F6CB04]">Beranda</a>
                <a href="{{ route('home') }}#tentang"
                    class="text-sm font-medium text-white transition-colors hover:text-[#F6CB04]">Tentang</a>

                {{-- Dropdown Alur PPDB --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="flex items-center gap-1 text-sm font-medium text-white transition-colors hover:text-[#F6CB04]">
                        Alur PPDB
                        <span class="material-symbols-outlined text-base transition-transform duration-200"
                            :style="open ? 'transform:rotate(180deg)' : ''">expand_more</span>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute left-0 mt-3 w-52 rounded-2xl overflow-hidden"
                        style="background-color:white; box-shadow:0 20px 60px rgba(0,0,0,0.15); border:1px solid rgba(1,139,62,0.1); top:100%;">
                        <a href="{{ route('home') }}#alur" @click="open = false"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-semibold transition-colors"
                            style="color:#018B3E;" onmouseover="this.style.backgroundColor='rgba(1,139,62,0.07)';"
                            onmouseout="this.style.backgroundColor='transparent';">
                            <span class="material-symbols-outlined text-base">route</span>
                            Alur Pendaftaran
                        </a>
                        <div style="height:1px; background-color:#f1f5f9; margin:0 16px;"></div>
                        <a href="{{ route('pengumuman.publik') }}" @click="open = false"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-semibold transition-colors"
                            style="color:#334155;"
                            onmouseover="this.style.backgroundColor='rgba(1,139,62,0.07)'; this.style.color='#018B3E';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='#334155';">
                            <span class="material-symbols-outlined text-base">campaign</span>
                            Pengumuman
                        </a>
                    </div>
                </div>

                <a href="{{ route('home') }}#syarat"
                    class="text-sm font-medium text-white transition-colors hover:text-[#F6CB04]">Syarat</a>
                <a href="{{ route('home') }}#faq"
                    class="text-sm font-medium text-white transition-colors hover:text-[#F6CB04]">FAQ</a>
            </nav>

            {{-- CTA Area --}}
            <div class="flex items-center gap-3">

                @auth
                    @php
                        $user = Auth::user();
                        $initials = collect(explode(' ', $user->nama_lengkap ?? $user->name))
                            ->map(fn($w) => strtoupper($w[0]))->take(2)->join('');
                        $dashboard = route('admin.dashboard');
                        $dashLabel = 'Panel Admin';
                        $dashIcon = 'admin_panel_settings';
                    @endphp

                    <div class="hidden md:block relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl transition-all"
                            style="background-color:rgba(255,255,255,0.12);"
                            onmouseover="this.style.backgroundColor='rgba(255,255,255,0.2)';"
                            onmouseout="this.style.backgroundColor='rgba(255,255,255,0.12)';">
                            <div class="size-8 rounded-full font-black text-xs flex items-center justify-center shrink-0"
                                style="background-color:#F6CB04; color:#0f2318;">{{ $initials }}</div>
                            <div class="flex flex-col text-left leading-tight">
                                <span
                                    class="text-sm font-bold text-white truncate max-w-[120px]">{{ Str::limit($user->nama_lengkap ?? $user->name, 18) }}</span>
                                <span class="text-[10px] font-medium"
                                    style="color:rgba(246,203,4,0.85);">{{ $user->isAdmin() ? 'Administrator' : 'Pendaftar' }}</span>
                            </div>
                            <span class="material-symbols-outlined text-sm text-white/70 transition-transform duration-200"
                                :style="open ? 'transform:rotate(180deg)' : ''">expand_more</span>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 rounded-2xl overflow-hidden"
                            style="background-color:white; box-shadow:0 20px 60px rgba(0,0,0,0.15); border:1px solid rgba(1,139,62,0.1); top:100%;">
                            <div class="px-4 py-3 border-b"
                                style="border-color:#f1f5f9; background-color:rgba(1,139,62,0.03);">
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Login sebagai</p>
                                <p class="text-sm font-bold text-slate-800 mt-0.5 truncate">
                                    {{ $user->nama_lengkap ?? $user->name }}
                                </p>
                                <p class="text-xs text-slate-400 truncate">{{ $user->email }}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{ $dashboard }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold transition-colors"
                                    style="color:#018B3E;" onmouseover="this.style.backgroundColor='rgba(1,139,62,0.07)';"
                                    onmouseout="this.style.backgroundColor='transparent';">
                                    <span class="material-symbols-outlined text-base">{{ $dashIcon }}</span>{{ $dashLabel }}
                                </a>

                            </div>
                            <div class="border-t py-2" style="border-color:#f1f5f9;">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-500 transition-colors"
                                        onmouseover="this.style.backgroundColor='rgba(239,68,68,0.07)';"
                                        onmouseout="this.style.backgroundColor='transparent';">
                                        <span class="material-symbols-outlined text-base">logout</span>Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    <a href="{{ route('pendaftaran') }}"
                        class="hidden sm:flex px-5 py-2 rounded-lg font-bold text-sm transition-all shadow-sm hover:brightness-110"
                        style="background-color:#F6CB04; color:#0f2318;">Daftar Sekarang</a>
                @endauth

                {{-- Hamburger mobile --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden btn btn-ghost btn-sm p-1 text-white" aria-label="Toggle Menu">
                    <span class="material-symbols-outlined text-2xl" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Nav Menu (Alpine.js) --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden border-t border-white/10"
         style="background-color: #018B3E;"
         x-cloak>
         <nav class="flex flex-col px-4 py-4 gap-2">
             <a href="{{ route('home') }}#beranda" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg text-sm font-semibold text-white hover:bg-white/10 transition-colors">Beranda</a>
             <a href="{{ route('home') }}#tentang" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg text-sm font-semibold text-white hover:bg-white/10 transition-colors">Tentang</a>
             <a href="{{ route('home') }}#syarat" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg text-sm font-semibold text-white hover:bg-white/10 transition-colors">Syarat</a>
             <a href="{{ route('home') }}#faq" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg text-sm font-semibold text-white hover:bg-white/10 transition-colors">FAQ</a>
             <a href="{{ route('pengumuman.publik') }}" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg text-sm font-semibold text-white hover:bg-white/10 transition-colors">Pengumuman</a>
             
             @auth
                 <div class="h-px bg-white/10 my-2"></div>
                 <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold text-white hover:bg-white/10 transition-colors">
                     <span class="material-symbols-outlined text-base">admin_panel_settings</span> Panel Admin
                 </a>
                 <form method="POST" action="{{ route('logout') }}" class="w-full">
                     @csrf
                     <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold text-red-300 hover:bg-red-500/10 transition-colors">
                         <span class="material-symbols-outlined text-base">logout</span> Keluar
                     </button>
                 </form>
             @else
                 <div class="h-px bg-white/10 my-2"></div>
                 <a href="{{ route('pendaftaran') }}" class="flex items-center justify-center px-5 py-2.5 rounded-lg font-bold text-sm text-[#0f2318] hover:brightness-110 transition-all text-center" style="background-color:#F6CB04;">Daftar Sekarang</a>
             @endauth
         </nav>
    </div>
</header>