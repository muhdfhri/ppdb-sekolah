<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PPDB SMK NU II Medan')</title>

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>

    @stack('styles')
</head>

<body class="font-['Public_Sans'] bg-[#F6F4F7] antialiased">

    {{-- ================================================================
    MOBILE SIDEBAR OVERLAY
    ================================================================ --}}
    <div id="mobile-sidebar" class="hidden fixed inset-0 z-50 lg:hidden">
        <div class="absolute inset-0 bg-black/50" onclick="toggleMobileSidebar()"></div>
        <aside class="absolute left-0 top-0 h-full w-72 bg-white flex flex-col p-6 shadow-xl">

            {{-- Logo --}}
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0">
                        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
                            class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="font-bold text-sm leading-tight text-[#018B3E]">SMK NU II<br />Medan</h1>
                        <p class="text-xs text-slate-500">Portal PPDB</p>
                    </div>
                </div>
                <button onclick="toggleMobileSidebar()" class="p-2 hover:bg-slate-100 rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            {{-- Nav --}}
            <nav class="flex flex-col gap-2 flex-1">
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium
                    {{ request()->routeIs('siswa.dashboard') ? 'text-white bg-[#018B3E]' : 'text-slate-600 hover:bg-[#018B3E]/5' }}">
                    <span class="material-symbols-outlined">home</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('siswa.pendaftaran.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium
                    {{ request()->routeIs('siswa.pendaftaran.*') && !request()->routeIs('siswa.pendaftaran.riwayat') ? 'text-white bg-[#018B3E]' : 'text-slate-600 hover:bg-[#018B3E]/5' }}">
                    <span class="material-symbols-outlined">assignment</span>
                    <span>Pendaftaran</span>
                </a>
                <a href="{{ route('siswa.pendaftaran.riwayat') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium
                    {{ request()->routeIs('siswa.pendaftaran.riwayat') ? 'text-white bg-[#018B3E]' : 'text-slate-600 hover:bg-[#018B3E]/5' }}">
                    <span class="material-symbols-outlined">history</span>
                    <span>Riwayat Pendaftaran</span>
                </a>

                {{-- TAMBAHKAN: Kembali ke Beranda (Landing Page) --}}
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium text-slate-600 hover:bg-[#018B3E]/5 mt-2">
                    <span class="material-symbols-outlined">home</span>
                    <span>Kembali ke Beranda</span>
                </a>

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
            </nav>

            {{-- Cetak Bukti --}}
            @php $pendaftaranLayout = auth()->user()?->pendaftaran()->latest()->first(); @endphp
            @if($pendaftaranLayout && $pendaftaranLayout->status !== 'draft')
                <button onclick="cetakBukti()"
                    class="w-full bg-[#F6CB04] text-[#0f2318] font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 hover:brightness-95 mt-4 transition-all">
                    <span class="material-symbols-outlined">print</span>
                    <span>Cetak Bukti</span>
                </button>
            @else
                <div class="w-full bg-slate-100 text-slate-400 font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed mt-4"
                    title="Selesaikan pendaftaran terlebih dahulu">
                    <span class="material-symbols-outlined">print</span>
                    <span>Cetak Bukti</span>
                </div>
            @endif

        </aside>
    </div>

    {{-- ================================================================
    DESKTOP SIDEBAR (fixed)
    ================================================================ --}}
    <aside class="hidden lg:flex fixed top-0 left-0 w-72 h-screen bg-white flex-col justify-between p-6 z-40"
        style="border-right: 1px solid rgba(1,139,62,0.1);">

        <div class="flex flex-col gap-8">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK NU II Medan"
                        class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="font-bold text-sm leading-tight text-[#018B3E]">SMK NU II<br />Medan</h1>
                    <p class="text-xs text-slate-500">Portal PPDB</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex flex-col gap-2">
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium
                    {{ request()->routeIs('siswa.dashboard') ? 'text-white bg-[#018B3E]' : 'text-slate-600 hover:bg-[#018B3E]/5' }}">
                    <span class="material-symbols-outlined">home</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('siswa.pendaftaran.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium
                    {{ request()->routeIs('siswa.pendaftaran.*') && !request()->routeIs('siswa.pendaftaran.riwayat') ? 'text-white bg-[#018B3E]' : 'text-slate-600 hover:bg-[#018B3E]/5' }}">
                    <span class="material-symbols-outlined">assignment</span>
                    <span>Pendaftaran</span>
                </a>
                <a href="{{ route('siswa.pendaftaran.riwayat') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium
                    {{ request()->routeIs('siswa.pendaftaran.riwayat') ? 'text-white bg-[#018B3E]' : 'text-slate-600 hover:bg-[#018B3E]/5' }}">
                    <span class="material-symbols-outlined">history</span>
                    <span>Riwayat Pendaftaran</span>
                </a>

                {{-- TAMBAHKAN: Kembali ke Beranda (Landing Page) --}}
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium text-slate-600 hover:bg-[#018B3E]/5 mt-2">
                    <span class="material-symbols-outlined">home</span>
                    <span>Kembali ke Beranda</span>
                </a>

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
            </nav>
        </div>

        {{-- Cetak Bukti --}}
        @if($pendaftaranLayout && $pendaftaranLayout->status !== 'draft')
            <button onclick="cetakBukti()"
                class="w-full bg-[#F6CB04] text-[#0f2318] font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 hover:brightness-95 transition-all">
                <span class="material-symbols-outlined">print</span>
                <span>Cetak Bukti</span>
            </button>
        @else
            <div class="w-full bg-slate-100 text-slate-400 font-bold py-4 px-4 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed"
                title="Selesaikan pendaftaran terlebih dahulu">
                <span class="material-symbols-outlined">print</span>
                <span>Cetak Bukti</span>
            </div>
        @endif

    </aside>

    {{-- ================================================================
    MAIN WRAPPER
    ================================================================ --}}
    <div class="lg:ml-72 min-h-screen flex flex-col">

        {{-- ── MOBILE HEADER ── --}}
        <div
            class="lg:hidden bg-white sticky top-0 z-40 px-4 py-3 flex items-center justify-between border-b border-slate-200">
            <button type="button" id="mobile-menu-button" class="p-2 rounded-lg hover:bg-slate-100">
                <span class="material-symbols-outlined text-slate-600">menu</span>
            </button>
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-full bg-[#018B3E]/10 border-2 border-[#018B3E]/20 flex items-center justify-center overflow-hidden">
                    @if(auth()->user()?->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto"
                            class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-sm text-[#018B3E]">person</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── DESKTOP HEADER ── --}}
        <header class="hidden lg:flex h-20 bg-white px-8 items-center justify-between sticky top-0 z-30"
            style="border-bottom: 1px solid #f1f5f9;">
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm">
                <span class="text-slate-400 font-medium">@yield('breadcrumb_parent', 'Portal')</span>
                <span class="material-symbols-outlined text-slate-300 text-lg">chevron_right</span>
                <span class="font-semibold text-[#018B3E]">@yield('breadcrumb', 'Dashboard')</span>
            </div>
            {{-- User info --}}
            <div class="flex items-center gap-3 pl-6" style="border-left: 1px solid #f1f5f9;">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-900 leading-none">{{ auth()->user()?->nama_lengkap }}</p>
                    <p class="text-xs text-slate-500 mt-1">@yield('header_sub', auth()->user()?->email ?? '—')</p>
                </div>
                <div
                    class="w-10 h-10 rounded-full bg-[#018B3E]/10 border-2 border-[#018B3E]/20 flex items-center justify-center overflow-hidden">
                    @if(auth()->user()?->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil"
                            class="w-full h-full object-cover">
                    @else
                        <span class="text-sm font-black text-[#018B3E]">
                            {{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'U', 0, 2)) }}
                        </span>
                    @endif
                </div>
            </div>
        </header>

        {{-- ── SESSION ALERTS ── --}}
        @if(session('success') || session('error'))
            <div class="px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
                @if(session('success'))
                    <div id="layout-alert-success"
                        class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold mb-0 transition-all duration-500"
                        style="background-color:#018B3E; color:white; box-shadow:0 4px 20px rgba(1,139,62,0.25);">
                        <span class="material-symbols-outlined text-base shrink-0">check_circle</span>
                        <span class="flex-1">{{ session('success') }}</span>
                        <button onclick="dismissLayoutAlert('layout-alert-success')"
                            class="opacity-80 hover:opacity-100 shrink-0">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div id="layout-alert-error"
                        class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold mb-0 transition-all duration-500"
                        style="background-color:#dc2626; color:white; box-shadow:0 4px 20px rgba(220,38,38,0.25);">
                        <span class="material-symbols-outlined text-base shrink-0">error</span>
                        <span class="flex-1">{{ session('error') }}</span>
                        <button onclick="dismissLayoutAlert('layout-alert-error')"
                            class="opacity-80 hover:opacity-100 shrink-0">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>
                @endif
            </div>
        @endif

        {{-- ── PAGE CONTENT ── --}}
        <div class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </div>

    </div>

    <script>
        // ── Mobile sidebar toggle ─────────────────────────
        function toggleMobileSidebar() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        }

        document.getElementById('mobile-menu-button')?.addEventListener('click', toggleMobileSidebar);

        // Close sidebar ketika klik di luar area aside
        document.addEventListener('click', function (e) {
            const sidebar = document.getElementById('mobile-sidebar');
            const btn = document.getElementById('mobile-menu-button');
            if (sidebar && !sidebar.classList.contains('hidden') &&
                !sidebar.contains(e.target) && !btn?.contains(e.target)) {
                sidebar.classList.add('hidden');
            }
        });

        // ── Cetak Bukti ───────────────────────────────────
        function cetakBukti() {
            const a = document.createElement('a');
            a.href = '{{ route("siswa.pendaftaran.cetak.pdf") }}';
            a.download = '';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            setTimeout(function () {
                window.location.href = '{{ route("siswa.pendaftaran.cetak") }}';
            }, 500);
        }

        // ── Auto-dismiss alerts ───────────────────────────
        function dismissLayoutAlert(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            setTimeout(() => el.remove(), 500);
        }

        document.addEventListener('DOMContentLoaded', function () {
            ['layout-alert-success', 'layout-alert-error'].forEach(id => {
                const el = document.getElementById(id);
                if (el) setTimeout(() => dismissLayoutAlert(id), 3000);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>