<?php

namespace App\Providers;

use App\Models\Cuti;
use App\Models\DatangTerlambat;
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
            $user = Auth::user();
            if (Auth::check()) {
                // Hitung data pending berdasarkan role user
                // Hitung Izin yang belum di-approve dari unit yang sama
                $pendingIzin = Izin::where('approve_1', 0)
                    ->whereHas('user', function ($query) use ($user) {
                        $query->where('unit', $user->unit); // Sesuaikan dengan unit user yang sedang login
                    })
                    ->count();

                // Hitung Lembur yang belum di-approve dari unit yang sama
                $pendingLembur = Lembur::where('approve_1', 0)
                    ->whereHas('user', function ($query) use ($user) {
                        $query->where('unit', $user->unit); // Sesuaikan dengan unit user yang sedang login
                    })
                    ->count();

                // Hitung Cuti yang belum di-approve dari unit yang sama
                $pendingCuti = Cuti::where('approve_1', 0)
                    ->whereHas('user', function ($query) use ($user) {
                        $query->where('unit', $user->unit); // Sesuaikan dengan unit user yang sedang login
                    })
                    ->count();

                // Hitung Datang Terlambat yang belum di-approve dari unit yang sama
                $pendingdt = DatangTerlambat::where('app_1', 0)
                    ->whereHas('karyn', function ($query) use ($user) {
                        $query->where('unit', $user->unit); // Sesuaikan dengan unit user yang sedang login
                    })
                    ->count();
                $pendingIzinsdi = Izin::where('approve_1', 1)
                    ->where('approve_2', 0)
                    ->count();
                $pendingLembursdi = Lembur::where('approve_1', 1)
                    ->where('approve_2', 0)
                    ->count();
                $pendingCutisdi = Cuti::where('approve_1', 1)
                    ->where('approve_2', 0)
                    ->count();
                $pendingdtsdi = DatangTerlambat::where('app_1', 1)
                    ->where('app_2', 0)
                    ->count();
                // Bagikan data ke semua view
                $view->with(compact('pendingIzin', 'pendingLembur', 'pendingCuti', 'pendingIzinsdi', 'pendingLembursdi', 'pendingCutisdi', 'pendingdt', 'pendingdtsdi'));
            }
        });
    }
}
