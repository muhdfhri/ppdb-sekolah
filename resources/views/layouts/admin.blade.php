<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - PPDB SMK NU II Medan</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#01893e",
                        "background-light": "#f5f8f7",
                        "background-dark": "#0f2318",
                    },
                    fontFamily: { "display": ["Public Sans", "sans-serif"] },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        .sidebar-item-active {
            background-color: rgba(1, 137, 62, 0.1);
            color: #01893e;
            border-right: 4px solid #01893e;
        }

        #sidebar {
            transition: transform 0.25s cubic-bezier(.4, 0, .2, 1);
        }

        #sidebar-overlay {
            transition: opacity 0.25s ease;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">

    {{-- Mobile overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/50 opacity-0 pointer-events-none lg:hidden"
        onclick="closeSidebar()">
    </div>

    <div class="flex h-screen overflow-hidden">

        {{-- ================================================================
        SIDEBAR
        ================================================================ --}}
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40
               w-64 -translate-x-full lg:translate-x-0
               bg-white dark:bg-slate-900
               border-r border-slate-200 dark:border-slate-800
               flex flex-col h-full shrink-0">

            {{-- Logo --}}
            <div class="p-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="size-10 bg-primary rounded-lg overflow-hidden shrink-0">
                        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
                            class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="font-bold text-sm leading-tight text-primary">SMK NU II</h1>
                        <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Admin Panel</p>
                    </div>
                </div>
                {{-- Close (mobile only) --}}
                <button onclick="closeSidebar()"
                    class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-4 space-y-1 mt-4 overflow-y-auto">

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                    {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span
                        class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'text-primary' : '' }}">dashboard</span>
                    <span
                        class="text-sm font-{{ request()->routeIs('admin.dashboard') ? 'semibold' : 'medium' }}">Dashboard</span>
                </a>

                <a href="{{ route('admin.pendaftar.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                    {{ request()->routeIs('admin.pendaftar.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span
                        class="material-symbols-outlined {{ request()->routeIs('admin.pendaftar.*') ? 'text-primary' : '' }}">person_add</span>
                    <span
                        class="text-sm font-{{ request()->routeIs('admin.pendaftar.*') ? 'semibold' : 'medium' }}">Pendaftar</span>
                </a>

                {{-- ★ BARU: Pengumuman --}}
                <a href="{{ route('admin.pengumuman.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                    {{ request()->routeIs('admin.pengumuman.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span
                        class="material-symbols-outlined {{ request()->routeIs('admin.pengumuman.*') ? 'text-primary' : '' }}">campaign</span>
                    <span
                        class="text-sm font-{{ request()->routeIs('admin.pengumuman.*') ? 'semibold' : 'medium' }}">Pengumuman</span>
                </a>

                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                    {{ request()->routeIs('admin.laporan.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span
                        class="material-symbols-outlined {{ request()->routeIs('admin.laporan.*') ? 'text-primary' : '' }}">description</span>
                    <span
                        class="text-sm font-{{ request()->routeIs('admin.laporan.*') ? 'semibold' : 'medium' }}">Laporan</span>
                </a>

                <a href="{{ route('admin.pengaturan.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                    {{ request()->routeIs('admin.pengaturan.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span
                        class="material-symbols-outlined {{ request()->routeIs('admin.pengaturan.*') ? 'text-primary' : '' }}">event_note</span>
                    <span
                        class="text-sm font-{{ request()->routeIs('admin.pengaturan.*') ? 'semibold' : 'medium' }}">Periode</span>
                </a>

                {{-- ── Divider + Label ─────────────────────────── --}}
                <div class="pt-3 pb-1">
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
                        <span
                            class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 shrink-0">
                            Manajemen
                        </span>
                        <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
                    </div>
                </div>

                {{-- Kelola Pengguna --}}
                <a href="{{ route('admin.pengguna.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                    {{ request()->routeIs('admin.pengguna.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span
                        class="material-symbols-outlined {{ request()->routeIs('admin.pengguna.*') ? 'text-primary' : '' }}">manage_accounts</span>
                    <span
                        class="text-sm font-{{ request()->routeIs('admin.pengguna.*') ? 'semibold' : 'medium' }}">Kelola
                        Pengguna</span>
                </a>

            </nav>

            {{-- Footer sidebar --}}
            <div class="p-4 border-t border-slate-200 dark:border-slate-800 shrink-0">
                <div class="bg-primary/5 rounded-xl p-4 flex flex-col gap-3">
                    <p class="text-xs font-medium text-slate-600 dark:text-slate-400">
                        Status Server: <span class="text-primary font-bold">Online</span>
                    </p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full py-2 bg-primary text-white rounded-lg text-xs font-bold shadow-sm hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">logout</span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        {{-- ================================================================
        MAIN
        ================================================================ --}}
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Header --}}
            <header
                class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-4 md:px-8 shrink-0">
                <div class="flex items-center gap-3 flex-1">
                    {{-- Hamburger — mobile only --}}
                    <button onclick="openSidebar()"
                        class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shrink-0">
                        <span class="material-symbols-outlined">menu</span>
                    </button>

                    {{-- SEARCH FORM --}}
                    <form action="{{ route('admin.pendaftar.index') }}" method="GET" class="relative w-full max-w-md">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-400 outline-none"
                            placeholder="Cari nama pendaftar atau NISN..." />
                        {{-- Hidden inputs untuk mempertahankan filter lain --}}
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if(request('jurusan_id'))
                            <input type="hidden" name="jurusan_id" value="{{ request('jurusan_id') }}">
                        @endif
                    </form>
                </div>

                <div class="flex items-center gap-4 shrink-0 ml-4">
                    <!-- <button
                        class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg relative transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                        <span
                            class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                    </button> -->
                    <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-700 mx-1"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold">{{ auth()->user()->nama_lengkap }}</p>
                            <p class="text-[10px] text-slate-500">Super Admin</p>
                        </div>
                        <div
                            class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <div class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8">

                @if(session('success'))
                    <div class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold"
                        style="background-color: rgba(1,137,62,0.08); border: 1px solid rgba(1,137,62,0.2); color: #015f2a;">
                        <span class="material-symbols-outlined text-base">check_circle</span>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold"
                        style="background-color: rgba(239,68,68,0.07); border: 1px solid rgba(239,68,68,0.2); color: #b91c1c;">
                        <span class="material-symbols-outlined text-base">error</span>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>

        </main>
    </div>

    <script>
        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.style.transform = 'translateX(0)';
            overlay.style.opacity = '1';
            overlay.classList.remove('pointer-events-none');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.style.transform = 'translateX(-100%)';
            overlay.style.opacity = '0';
            setTimeout(() => overlay.classList.add('pointer-events-none'), 250);
        }
    </script>

    @stack('scripts')
</body>

</html>