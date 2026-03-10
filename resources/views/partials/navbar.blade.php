{{-- Mobile Drawer (DaisyUI) --}}
<div class="drawer drawer-end">
    <input id="mobile-drawer" type="checkbox" class="drawer-toggle" />

    <div class="drawer-content flex flex-col">
        {{-- Navbar --}}
        <header class="sticky top-0 z-50 w-full shadow-md" style="background-color: #018B3E; color: white;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">

                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="size-10 rounded-full flex items-center justify-center p-1"
                            style="background-color: white;">
                            <span class="material-symbols-outlined text-2xl" style="color: #018B3E;">school</span>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-sm sm:text-lg font-bold leading-tight tracking-tight uppercase">SMK NU II
                                Medan</h2>
                            <span class="text-[10px] opacity-75">Mencetak Generasi Unggul & Islami</span>
                        </div>
                    </a>

                    {{-- Desktop Nav --}}
                    <nav class="hidden md:flex items-center gap-8">
                        <a class="text-sm font-medium transition-colors" style="color: white;"
                            onmouseover="this.style.color='#F6CB04';" onmouseout="this.style.color='white';"
                            href="#beranda">Beranda</a>
                        <a class="text-sm font-medium transition-colors" style="color: white;"
                            onmouseover="this.style.color='#F6CB04';" onmouseout="this.style.color='white';"
                            href="#tentang">Tentang</a>
                        <a class="text-sm font-medium transition-colors" style="color: white;"
                            onmouseover="this.style.color='#F6CB04';" onmouseout="this.style.color='white';"
                            href="#alur">Alur PPDB</a>
                        <a class="text-sm font-medium transition-colors" style="color: white;"
                            onmouseover="this.style.color='#F6CB04';" onmouseout="this.style.color='white';"
                            href="#syarat">Syarat</a>
                        <a class="text-sm font-medium transition-colors" style="color: white;"
                            onmouseover="this.style.color='#F6CB04';" onmouseout="this.style.color='white';"
                            href="#faq">FAQ</a>
                    </nav>

                    {{-- CTA & Hamburger --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('register') }}"
                            class="hidden sm:flex px-5 py-2 rounded-lg font-bold text-sm transition-all shadow-sm hover:brightness-110"
                            style="background-color: #F6CB04; color: #0f2318;">
                            Daftar Sekarang
                        </a>
                        {{-- Hamburger (mobile only) --}}
                        <label for="mobile-drawer" class="md:hidden btn btn-ghost btn-sm p-1" style="color: white;">
                            <span class="material-symbols-outlined text-2xl">menu</span>
                        </label>
                    </div>

                </div>
            </div>
        </header>
    </div>

    {{-- Drawer Side (Mobile Menu) --}}
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

            {{-- Nav Links --}}
            <nav class="flex flex-col px-4 py-6 gap-1 flex-1">
                @foreach([
                        ['href' => '#beranda', 'icon' => 'home', 'label' => 'Beranda'],
                        ['href' => '#tentang', 'icon' => 'info', 'label' => 'Tentang'],
                        ['href' => '#alur', 'icon' => 'route', 'label' => 'Alur PPDB'],
                        ['href' => '#syarat', 'icon' => 'checklist', 'label' => 'Syarat'],
                        ['href' => '#faq', 'icon' => 'help', 'label' => 'FAQ'],
                    ] as $item)
                    <a href="{{ $item['href'] }}"
                        onclick="document.getElementById('mobile-drawer').checked = false;"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                        style="color: rgba(255,255,255,0.75);"
                        onmouseover="this.style.backgroundColor='rgba(1,139,62,0.25)'; this.style.color='white';"
                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.75)';">
                        <span class="material-symbols-outlined text-xl" style="color: #018B3E;">{{ $item['icon'] }}</span>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Drawer CTA --}}
            <div class="px-4 pb-8 pt-2 border-t" style="border-color: rgba(255,255,255,0.08);">
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
            </div>

        </div>
    </div>
</div>