<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
{
    // Pastikan pengguna sudah login dan memiliki role 'admin' atau 'super admin'
    if (Auth::check() && in_array(Auth::user()->role, ['admin', 'super admin'])) {
        return $next($request);
    }

    // Jika bukan admin, arahkan ke halaman lain (contoh: dashboard user)
    return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
}

}
