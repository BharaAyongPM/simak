<?php

namespace App\Providers;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Lembur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Cek jika user sudah login
        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Hitung data pending berdasarkan role user
                $pendingIzin = Izin::where('approve_1', 0)->count();
                $pendingLembur = Lembur::where('approve_1', 0)->count();
                $pendingCuti = Cuti::where('approve_1', 0)->count();
                $pendingIzinsdi = Izin::where('approve_1', 1)
                    ->where('approve_2', 0)
                    ->count();
                $pendingLembursdi = Lembur::where('approve_1', 1)
                    ->where('approve_2', 0)
                    ->count();
                $pendingCutisdi = Cuti::where('approve_1', 1)
                    ->where('approve_2', 0)
                    ->count();

                // Bagikan data ke semua view
                $view->with(compact('pendingIzin', 'pendingLembur', 'pendingCuti', 'pendingIzinsdi', 'pendingLembursdi', 'pendingCutisdi'));
            }
        });
    }
}
