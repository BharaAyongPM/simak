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
                // Inisialisasi variabel untuk pending data
                $pendingIzin = 0;
                $pendingLembur = 0;
                $pendingCuti = 0;
                $pendingdt = 0;
                $pendingIzinsdi = 0;
                $pendingLembursdi = 0;
                $pendingCutisdi = 0;
                $pendingdtsdi = 0;

                // Jika user adalah Kepala Unit, hitung data pending dari Karyawan
                if ($user->hasRole('KEPALA UNIT')) {
                    // Hitung Izin dari Karyawan yang belum di-approve
                    $pendingIzin = Izin::where('approve_1', 0)
                        ->whereHas('user', function ($query) use ($user) {
                            $query->where('unit', $user->unit)
                                ->whereHas('roles', function ($q) {
                                    $q->where('name', 'KARYAWAN'); // Hanya dari Karyawan
                                });
                        })
                        ->count();

                    // Hitung Lembur dari Karyawan yang belum di-approve
                    $pendingLembur = Lembur::where('approve_1', 0)
                        ->whereHas('user', function ($query) use ($user) {
                            $query->where('unit', $user->unit)
                                ->whereHas('roles', function ($q) {
                                    $q->where('name', 'KARYAWAN'); // Hanya dari Karyawan
                                });
                        })
                        ->count();

                    // Hitung Cuti dari Karyawan yang belum di-approve
                    $pendingCuti = Cuti::where('approve_1', 0)
                        ->whereHas('user', function ($query) use ($user) {
                            $query->where('unit', $user->unit)
                                ->whereHas('roles', function ($q) {
                                    $q->where('name', 'KARYAWAN'); // Hanya dari Karyawan
                                });
                        })
                        ->count();

                    // Hitung Datang Terlambat dari Karyawan yang belum di-approve
                    $pendingdt = DatangTerlambat::where('app_1', 0)
                        ->whereHas('karyn', function ($query) use ($user) {
                            $query->where('unit', $user->unit)
                                ->whereHas('roles', function ($q) {
                                    $q->where('name', 'KARYAWAN'); // Hanya dari Karyawan
                                });
                        })
                        ->count();
                }
                // Jika user adalah Kepala Bagian, hitung data pending dari Kepala Unit
                elseif ($user->hasRole('KEPALA BAGIAN')) {
                    // Hitung Izin dari Kepala Unit yang belum di-approve
                    $pendingIzin = Izin::where('approve_1', 0)
                        ->whereHas('user', function ($query) use ($user) {
                            $query->where('divisi', $user->divisi)
                                ->whereHas('roles', function ($q) {
                                    $q->where('name', 'KEPALA UNIT'); // Hanya dari Kepala Unit
                                });
                        })
                        ->count();

                    // Hitung Lembur dari Kepala Unit yang belum di-approve
                    $pendingLembur = Lembur::where('approve_1', 0)
                        ->whereHas('user', function ($query) use ($user) {
                            $query->where('divisi', $user->divisi)
                                ->whereHas('roles', function ($q) {
                                    $q->where('name', 'KEPALA UNIT'); // Hanya dari Kepala Unit
                                });
                        })
                        ->count();

                    // Hitung Cuti dari Kepala Unit yang belum di-approve
                    $pendingCuti = Cuti::where('approve_1', 0)
                        ->whereHas('user', function ($query) use ($user) {
                            $query->where('divisi', $user->divisi)
                                ->whereHas('roles', function ($q) {
                                    $q->where('name', 'KEPALA UNIT'); // Hanya dari Kepala Unit
                                });
                        })
                        ->count();

                    // Hitung Datang Terlambat dari Kepala Unit yang belum di-approve
                    $pendingdt = DatangTerlambat::where('app_1', 0)
                        ->whereHas('karyn', function ($query) use ($user) {
                            $query->where('divisi', $user->divisi)
                                ->whereHas('roles', function ($q) {
                                    $q->where('name', 'KEPALA UNIT'); // Hanya dari Kepala Unit
                                });
                        })
                        ->count();
                }
                // Jika user adalah Direktur, hitung data pending dari Kepala Bagian
                elseif ($user->hasRole('DIREKTUR')) {
                    // Hitung Izin dari Kepala Bagian yang belum di-approve
                    $pendingIzin = Izin::where('approve_1', 0)
                        ->whereHas('user', function ($query) {
                            $query->whereHas('roles', function ($q) {
                                $q->where('name', 'KEPALA BAGIAN'); // Hanya dari Kepala Bagian
                            });
                        })
                        ->count();

                    // Hitung Lembur dari Kepala Bagian yang belum di-approve
                    $pendingLembur = Lembur::where('approve_1', 0)
                        ->whereHas('user', function ($query) {
                            $query->whereHas('roles', function ($q) {
                                $q->where('name', 'KEPALA BAGIAN'); // Hanya dari Kepala Bagian
                            });
                        })
                        ->count();

                    // Hitung Cuti dari Kepala Bagian yang belum di-approve
                    $pendingCuti = Cuti::where('approve_1', 0)
                        ->whereHas('user', function ($query) {
                            $query->whereHas('roles', function ($q) {
                                $q->where('name', 'KEPALA BAGIAN'); // Hanya dari Kepala Bagian
                            });
                        })
                        ->count();

                    // Hitung Datang Terlambat dari Kepala Bagian yang belum di-approve
                    $pendingdt = DatangTerlambat::where('app_1', 0)
                        ->whereHas('karyn', function ($query) {
                            $query->whereHas('roles', function ($q) {
                                $q->where('name', 'KEPALA BAGIAN'); // Hanya dari Kepala Bagian
                            });
                        })
                        ->count();
                }

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
