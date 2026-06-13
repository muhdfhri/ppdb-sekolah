<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" style="color-scheme: light;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PPDB SMK NU II Medan')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="font-sans bg-background-light text-slate-900 antialiased min-h-screen flex flex-col">

    {{-- Toast/Alert System Container --}}
    <div id="toast-container"
        class="fixed top-24 right-4 z-50 max-w-md w-full px-4 sm:px-0 flex flex-col gap-2 pointer-events-none">
        @if(session('success'))
            <div id="toast-success"
                class="pointer-events-auto flex items-center gap-3 p-4 rounded-xl text-sm font-semibold text-white shadow-lg bg-brand-primary border border-brand-primary/25 transition-all duration-500">
                <span class="material-symbols-outlined text-lg shrink-0">check_circle</span>
                <span class="flex-1">{{ session('success') }}</span>
                <button onclick="document.getElementById('toast-success').remove()"
                    class="opacity-80 hover:opacity-100 shrink-0">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div id="toast-error"
                class="pointer-events-auto flex items-center gap-3 p-4 rounded-xl text-sm font-semibold text-white shadow-lg bg-error border border-error/20 transition-all duration-500">
                <span class="material-symbols-outlined text-lg shrink-0">warning</span>
                <span class="flex-1">{{ session('error') }}</span>
                <button onclick="document.getElementById('toast-error').remove()"
                    class="opacity-80 hover:opacity-100 shrink-0">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        @endif
    </div>

    <script>
        // Global toast utility
        window.showToast = function (message, type = 'error') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toastId = 'toast-' + Math.random().toString(36).substr(2, 9);
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = 'pointer-events-auto flex items-center gap-3 p-4 rounded-xl text-sm font-semibold text-white transition-all duration-500 shadow-lg';

            if (type === 'success') {
                toast.classList.add('bg-brand-primary', 'border', 'border-brand-primary/25');
                toast.innerHTML = `
                    <span class="material-symbols-outlined text-lg shrink-0">check_circle</span>
                    <span class="flex-1">${message}</span>
                    <button onclick="document.getElementById('${toastId}').remove()" class="opacity-80 hover:opacity-100 shrink-0">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                `;
            } else {
                toast.classList.add('bg-error', 'border', 'border-error/20');
                toast.innerHTML = `
                    <span class="material-symbols-outlined text-lg shrink-0">warning</span>
                    <span class="flex-1">${message}</span>
                    <button onclick="document.getElementById('${toastId}').remove()" class="opacity-80 hover:opacity-100 shrink-0">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                `;
            }

            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-10px)';
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        };

        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                ['toast-success', 'toast-error', 'toast-validation'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(-10px)';
                        setTimeout(() => el.remove(), 500);
                    }
                });
            }, 4000);
        });
    </script>

    {{-- Main View Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>