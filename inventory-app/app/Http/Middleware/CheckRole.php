<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user belum login, lempar ke halaman login
        if (! Auth::check()) {
            return redirect('login');
        }

        // Ambil nama role dari user yang sedang login (antisipasi jika objek relasi lama masih terbaca sebelum migrasi dijalankan)
        $userRole = Auth::user()->role;
        if (is_object($userRole) && isset($userRole->name)) {
            $userRole = $userRole->name;
        }

        $userRoleStr = is_string($userRole) ? $userRole : '';

        // Cek apakah role user ada di dalam daftar role yang diizinkan (Case Insensitive)
        if (in_array(strtolower($userRoleStr), array_map('strtolower', $roles))) {
            return $next($request);
        }

        // Jika gagal hak akses di halaman dashboard, jangan redirect ke dashboard lagi (mencegah loop)
        if ($request->is('dashboard') || $request->is('*/dashboard')) {
            Auth::logout();

            return redirect('/login')->with('error', 'Invalid login session or database not migrated. Please run php artisan migrate:fresh --seed.');
        }

        // Jika tidak punya akses di halaman lain, arahkan ke dashboard
        return redirect('/dashboard')->with('error', 'You do not have permission to access that page.');
    }
}
