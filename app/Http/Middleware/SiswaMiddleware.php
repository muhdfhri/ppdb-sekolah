<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login → ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Bukan siswa (misal admin nyasar ke area siswa)
        if (Auth::user()->role !== 'siswa') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}