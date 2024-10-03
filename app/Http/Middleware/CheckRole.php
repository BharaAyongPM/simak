<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $roles  Role yang akan diperiksa, bisa berupa beberapa role dipisahkan dengan |
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login'); // Redirect ke login jika belum login
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil semua role user dan ubah ke lowercase
        $userRoles = $user->roles->pluck('name')->map(function ($role) {
            return strtolower($role); // Ubah role user ke lowercase
        });

        // Pecah role yang diizinkan (misal ADMIN|HRD) menjadi array
        $allowedRoles = explode('|', strtolower($roles));

        // Cek apakah salah satu role user cocok dengan role yang diizinkan
        if (!$userRoles->intersect($allowedRoles)->count()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
