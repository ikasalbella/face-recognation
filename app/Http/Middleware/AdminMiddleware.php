<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('🧠 Middleware Admin Jalan');

        if (Auth::check()) {
            Log::info('User terautentikasi: ', ['email' => Auth::user()->email, 'role' => Auth::user()->role]);

            if (Auth::user()->role === 'admin') {
                return $next($request);
            }

            // Kalau login tapi bukan admin
            return redirect('/login')->withErrors([
                'akses' => 'Akses ditolak. Anda bukan admin.',
            ]);
        }

        // Belum login
        return redirect('/login');
    }
}
