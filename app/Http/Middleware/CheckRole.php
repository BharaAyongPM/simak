<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login'); // Redirect ke login jika belum login
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil semua role user dan ubah ke lowercase
        $roles = $user->roles->pluck('name')->map(function ($role) {
            return strtolower($role); // Ubah role ke lowercase
        });

        // Cek apakah role yang diminta ada di dalam list role user
        if (!$roles->contains(strtolower($role))) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
