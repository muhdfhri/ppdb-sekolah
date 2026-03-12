<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PPDB SMK NU II Medan')</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    @stack('styles')
</head>

<body class="font-sans bg-background-light text-slate-800 antialiased">

    {{-- ================================================================
    MOBILE HEADER (hanya muncul di layar kecil)
    ================================================================ --}}
    <div
        class="lg:hidden bg-white sticky top-0 z-50 px-4 py-3 flex items-center justify-between border-b border-slate-200">
        <div class="flex items-center gap-2">
            <button type="button" id="mobile-menu-button" class="p-2 rounded-lg hover:bg-slate-100 transition-all">
                <span class="material-symbols-outlined text-slate-600">menu</span>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-xl">school</span>
                </div>
                <span class="font-bold text-sm text-primary">SMK NU II</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button class="relative p-2 hover:text-primary transition-all">
                <span class="material-symbols-outlined text-slate-600">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div class="w-8 h-8 rounded-full bg-primary/10 border-2 border-primary/20 flex items-center justify-center">
                @if(auth()->user()->foto ?? false)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto"
                        class="w-full h-full object-cover rounded-full">
                @else
                    <span class="material-symbols-outlined text-sm text-primary">person</span>
                @endif
            </div>
        </div>
    </div>

    {{-- ================================================================
    MOBILE SIDEBAR (hidden by default)
    ================================================================ --}}
    <div id="mobile-sidebar" class="hidden fixed inset-0 z-50 lg:hidden">
        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/50" onclick="toggleMobileSidebar()"></div>

        {{-- Sidebar --}}
        <aside class="absolute left-0 top-0 h-full w-72 bg-white flex flex-col p-6 shadow-xl overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-2xl">school</span>
                    </div>
                    <div>
                        <h1 class="font-bold text-sm leading-tight text-primary">SMK NU II<br />Medan</h1>
                        <p class="text-xs text-slate-500">Portal PPDB</p>
                    </div>
                </div>
                <button onclick="toggleMobileSidebar()" class="p-2 hover:bg-slate-100 rounded-lg transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            {{-- Nav Links Mobile --}}
            <nav class="flex flex-col gap-2 flex-1">
                @yield('sidebar')
            </nav>

            {{-- Logout Mobile --}}
            <div class="mt-6 pt-6 border-t border-slate-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>

            {{-- Cetak Bukti Mobile --}}
            <button
                class="w-full bg-secondary text-background-dark font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 transition-all hover:brightness-95 mt-4">
                <span class="material-symbols-outlined">print</span>
                <span>Cetak Bukti</span>
            </button>
        </aside>
    </div>

    {{-- ================================================================
    DESKTOP LAYOUT
    ================================================================ --}}
    <div class="hidden lg:flex min-h-screen">
        {{-- Desktop Sidebar --}}
        <aside
            class="w-72 bg-white flex flex-col justify-between p-6 sticky top-0 h-screen shrink-0 border-r border-primary/10">
            <div class="flex flex-col gap-8">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-primary flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-3xl">school</span>
                    </div>
                    <div>
                        <h1 class="font-bold text-sm leading-tight text-primary">SMK NU II<br />Medan</h1>
                        <p class="text-xs text-slate-500">Portal PPDB</p>
                    </div>
                </div>

                {{-- Nav Links Desktop --}}
                <nav class="flex flex-col gap-2">
                    @yield('sidebar')
                </nav>

                {{-- Logout Desktop --}}
                <div class="mt-4 pt-4 border-t border-slate-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all">
                            <span class="material-symbols-outlined">logout</span>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Cetak Bukti Desktop --}}
            <button
                class="w-full bg-secondary text-background-dark font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 transition-all hover:brightness-95">
                <span class="material-symbols-outlined">print</span>
                <span>Cetak Bukti</span>
            </button>
        </aside>

        {{-- Desktop Main Content --}}
        <main class="flex-1 flex flex-col">
            {{-- Desktop Header --}}
            <header class="h-20 bg-white px-8 flex items-center justify-between border-b border-slate-100">
                <div class="flex items-center gap-2">
                    @yield('breadcrumb')
                </div>
                <div class="flex items-center gap-6">
                    <button class="relative p-2 text-slate-400 hover:text-primary transition-all">
                        <span class="material-symbols-outlined">notifications</span>
                        <span
                            class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="flex items-center gap-3 pl-6 border-l border-slate-100">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-900 leading-none">
                                {{ auth()->user()->nama_lengkap ?? 'User' }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">ID: {{ auth()->user()->id ?? '—' }}</p>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-primary/10 border-2 border-primary/20 flex items-center justify-center overflow-hidden">
                            @if(auth()->user()->foto ?? false)
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-xl text-primary">person</span>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            {{-- Desktop Content Area --}}
            <div class="flex-1 p-8 overflow-y-auto">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- ================================================================
    MOBILE CONTENT (di luar sidebar)
    ================================================================ --}}
    <div class="lg:hidden">
        {{-- Mobile Header Breadcrumb --}}
        <div class="bg-white px-4 py-2 border-b border-slate-100 flex items-center gap-1 text-sm">
            @yield('mobile-breadcrumb')
        </div>

        {{-- Mobile Content --}}
        <div class="p-4">
            @yield('content')
        </div>
    </div>

    {{-- ================================================================
    JAVASCRIPT
    ================================================================ --}}
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
            } else {
                sidebar.classList.add('hidden');
            }
        }

        // Close sidebar when clicking outside
        document.addEventListener('click', function (e) {
            const sidebar = document.getElementById('mobile-sidebar');
            const menuButton = document.getElementById('mobile-menu-button');

            if (sidebar && !sidebar.classList.contains('hidden')) {
                if (!sidebar.contains(e.target) && !menuButton?.contains(e.target)) {
                    sidebar.classList.add('hidden');
                }
            }
        });

        // Close sidebar on escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('mobile-sidebar');
                if (sidebar && !sidebar.classList.contains('hidden')) {
                    sidebar.classList.add('hidden');
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>