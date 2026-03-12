<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login → ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Sudah login tapi bukan admin → ke home
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Anda bukan admin.');
        }

        return $next($request);
    }
}