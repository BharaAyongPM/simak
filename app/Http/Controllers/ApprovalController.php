<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\DatangTerlambat;
use App\Models\Izin;
use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function approve1(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);

        // Logika approve 1 untuk Kepala Unit
        if (Auth::user()->hasRole('KEPALA UNIT') && Auth::user()->unit == $izin->user->unit) {
            $izin->approve_1 = 1;
            $izin->approved_by_1 = Auth::id();
            $izin->keterangan1 = $request->input('keterangan1');
            $izin->save();
            return redirect()->back()->with('success', 'Izin telah diapprove oleh Kepala Unit.');
        }

        // Logika approve 1 untuk Kepala Bagian (ketika Kepala Unit yang mengajukan)
        elseif (Auth::user()->hasRole('KEPALA BAGIAN') && Auth::user()->unit == $izin->user->unit && $izin->user->hasRole('KEPALA UNIT')) {
            $izin->approve_1 = 1;
            $izin->approved_by_1 = Auth::id();
            $izin->keterangan1 = $request->input('keterangan1');
            $izin->save();
            return redirect()->back()->with('success', 'Izin telah diapprove oleh Kepala Bagian.');
        }

        // Logika approve 1 untuk Direktur (ketika Kepala Bagian yang mengajukan)
        elseif (Auth::user()->hasRole('DIREKTUR') && $izin->user->hasRole('KEPALA BAGIAN')) {
            $izin->approve_1 = 1;
            $izin->approved_by_1 = Auth::id();
            $izin->keterangan1 = $request->input('keterangan1');
            $izin->save();
            return redirect()->back()->with('success', 'Izin telah diapprove oleh Direktur.');
        }

        // Jika user tidak memiliki hak untuk approve
        else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve.');
        }
    }
    public function reject1(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);

        // Logika reject 1 untuk Kepala Unit
        if (Auth::user()->hasRole('KEPALA UNIT') && Auth::user()->unit == $izin->user->unit) {
            $izin->approve_1 = -1; // Diset 0 untuk menolak
            $izin->approved_by_1 = Auth::id();
            $izin->keterangan1 = $request->input('keterangan1'); // Alasan penolakan
            $izin->save();
            return redirect()->back()->with('success', 'Izin telah ditolak oleh Kepala Unit.');
        }

        // Logika reject 1 untuk Kepala Bagian (ketika Kepala Unit yang mengajukan)
        elseif (Auth::user()->hasRole('KEPALA BAGIAN') && Auth::user()->unit == $izin->user->unit && $izin->user->hasRole('KEPALA UNIT')) {
            $izin->approve_1 = -1; // Diset 0 untuk menolak
            $izin->approved_by_1 = Auth::id();
            $izin->keterangan1 = $request->input('keterangan1'); // Alasan penolakan
            $izin->save();
            return redirect()->back()->with('success', 'Izin telah ditolak oleh Kepala Bagian.');
        }

        // Logika reject 1 untuk Direktur (ketika Kepala Bagian yang mengajukan)
        elseif (Auth::user()->hasRole('DIREKTUR') && $izin->user->hasRole('KEPALA BAGIAN')) {
            $izin->approve_1 = -1; // Diset 0 untuk menolak
            $izin->approved_by_1 = Auth::id();
            $izin->keterangan1 = $request->input('keterangan1'); // Alasan penolakan
            $izin->save();
            return redirect()->back()->with('success', 'Izin telah ditolak oleh Direktur.');
        }

        // Jika user tidak memiliki hak untuk reject
        else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak.');
        }
    }

    public function approve2Index()
    {
        // Data izin yang belum diapprove oleh approve 2
        $izinBelumDisetujui = Izin::where('approve_1', 1)
            ->where('approve_2', 0)
            ->get();

        // Data izin yang sudah diapprove oleh approve 2
        $izinDisetujui = Izin::where('approve_2', 1)
            ->get();

        // Data izin yang ditolak oleh approve 2
        $izinDitolak = Izin::where('approve_2', -1)
            ->get();

        // Gabungkan izinDisetujui dan izinDitolak untuk tampil dalam satu tab "History"
        $izinApprovedOrRejected = $izinDisetujui->merge($izinDitolak);

        return view('izin.approval2', compact('izinBelumDisetujui', 'izinApprovedOrRejected'));
    }

    public function approve2(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);

        // Logika untuk HRD approval 2
        if (Auth::user()->hasRole('HRD')) {
            $izin->approve_2 = 1;
            $izin->approved_by_2 = Auth::id();
            $izin->keterangan2 = $request->input('keterangan2');
            $izin->save();

            return redirect()->back()->with('success', 'Izin telah diapprove oleh HRD.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve.');
        }
    }
    public function reject2(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);

        // Logika untuk HRD rejection
        if (Auth::user()->hasRole('HRD')) {
            $izin->approve_2 = -1; // -1 untuk rejected
            $izin->approved_by_2 = Auth::id();
            $izin->keterangan2 = $request->input('keterangan2');
            $izin->save();

            return redirect()->back()->with('success', 'Izin telah ditolak oleh HRD.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak.');
        }
    }
    public function approveLembur1(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);

        // Logika approve lembur 1 untuk Kepala Unit
        if (Auth::user()->hasRole('KEPALA UNIT') && Auth::user()->unit == $lembur->user->unit) {
            $lembur->approve_1 = 1;
            $lembur->approved_by_1 = Auth::id();
            $lembur->keterangan1 = $request->input('keterangan1');
            $lembur->save();
            return redirect()->back()->with('success', 'Lembur telah diapprove oleh Kepala Unit.');
        }

        // Logika approve lembur 1 untuk Kepala Bagian (ketika Kepala Unit yang mengajukan lembur)
        elseif (Auth::user()->hasRole('KEPALA BAGIAN') && Auth::user()->unit == $lembur->user->unit && $lembur->user->hasRole('KEPALA UNIT')) {
            $lembur->approve_1 = 1;
            $lembur->approved_by_1 = Auth::id();
            $lembur->keterangan1 = $request->input('keterangan1');
            $lembur->save();
            return redirect()->back()->with('success', 'Lembur telah diapprove oleh Kepala Bagian.');
        }

        // Logika approve lembur 1 untuk Direktur (ketika Kepala Bagian yang mengajukan lembur)
        elseif (Auth::user()->hasRole('DIREKTUR') && $lembur->user->hasRole('KEPALA BAGIAN')) {
            $lembur->approve_1 = 1;
            $lembur->approved_by_1 = Auth::id();
            $lembur->keterangan1 = $request->input('keterangan1');
            $lembur->save();
            return redirect()->back()->with('success', 'Lembur telah diapprove oleh Direktur.');
        }

        // Jika user tidak memiliki hak untuk approve
        else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve.');
        }
    }
    public function rejectLembur1(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);

        // Logika reject lembur 1 untuk Kepala Unit
        if (Auth::user()->hasRole('KEPALA UNIT') && Auth::user()->unit == $lembur->user->unit) {
            $lembur->approve_1 = -1; // Menandakan lembur ditolak
            $lembur->approved_by_1 = Auth::id();
            $lembur->keterangan1 = $request->input('keterangan1');
            $lembur->save();
            return redirect()->back()->with('success', 'Lembur telah ditolak oleh Kepala Unit.');
        }

        // Logika reject lembur 1 untuk Kepala Bagian (ketika Kepala Unit yang mengajukan lembur)
        elseif (Auth::user()->hasRole('KEPALA BAGIAN') && Auth::user()->unit == $lembur->user->unit && $lembur->user->hasRole('KEPALA UNIT')) {
            $lembur->approve_1 = -1; // Menandakan lembur ditolak
            $lembur->approved_by_1 = Auth::id();
            $lembur->keterangan1 = $request->input('keterangan1');
            $lembur->save();
            return redirect()->back()->with('success', 'Lembur telah ditolak oleh Kepala Bagian.');
        }

        // Logika reject lembur 1 untuk Direktur (ketika Kepala Bagian yang mengajukan lembur)
        elseif (Auth::user()->hasRole('DIREKTUR') && $lembur->user->hasRole('KEPALA BAGIAN')) {
            $lembur->approve_1 = -1; // Menandakan lembur ditolak
            $lembur->approved_by_1 = Auth::id();
            $lembur->keterangan1 = $request->input('keterangan1');
            $lembur->save();
            return redirect()->back()->with('success', 'Lembur telah ditolak oleh Direktur.');
        }

        // Jika user tidak memiliki hak untuk reject
        else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak lembur.');
        }
    }

    public function approveLembur2(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);

        // Logika approve lembur 2 untuk HRD
        if (Auth::user()->hasRole('HRD')) {
            $lembur->approve_2 = 1;
            $lembur->approved_by_2 = Auth::id();
            $lembur->keterangan2 = $request->input('keterangan2');
            $lembur->save();

            return redirect()->back()->with('success', 'Lembur telah diapprove oleh HRD.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve.');
        }
    }
    public function rejectLembur2(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);

        // Logika reject lembur 2 untuk HRD
        if (Auth::user()->hasRole('HRD')) {
            $lembur->approve_2 = -1; // -1 menandakan ditolak
            $lembur->approved_by_2 = Auth::id();
            $lembur->keterangan2 = $request->input('keterangan2');
            $lembur->save();

            return redirect()->back()->with('success', 'Lembur telah ditolak oleh HRD.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk reject.');
        }
    }
    public function viewLemburKepalaUnit()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil data lembur yang masih butuh approval 1 oleh Kepala Unit
        $lemburBelumDisetujui = Lembur::where('approve_1', 0)
            ->whereHas('user', function ($query) use ($user) {
                $query->where('unit', $user->unit); // Hanya lembur dari unit yang sama
            })
            ->get();

        // Ambil data lembur yang sudah di-approve atau ditolak oleh Kepala Unit (History)
        $lemburDisetujui = Lembur::whereIn('approve_1', [1, -1]) // 1 = approved, -1 = rejected
            ->whereHas('user', function ($query) use ($user) {
                $query->where('unit', $user->unit);
            })
            ->get();

        return view('lembur.approval1', compact('lemburBelumDisetujui', 'lemburDisetujui'));
    }


    public function viewLemburHRD()
    {
        // Ambil data lembur yang butuh approval 2 oleh HRD
        $lemburBelumDisetujui = Lembur::where('approve_1', 1) // Hanya lembur yang sudah di-approve oleh kepala unit
            ->where('approve_2', 0)
            ->get();

        // Ambil data lembur yang sudah di-approve oleh HRD (History)
        $lemburDisetujui = Lembur::whereIn('approve_2',  [1, -1])
            ->get();

        return view('lembur.approval2', compact('lemburBelumDisetujui', 'lemburDisetujui'));
    }

    public function approveCuti1(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        // Logika approve cuti oleh Kepala Unit, Kepala Bagian, atau Direktur
        if (Auth::user()->hasRole('KEPALA UNIT') && Auth::user()->unit == $cuti->user->unit) {
            $cuti->approve_1 = 1;
            $cuti->approved_by_1 = Auth::id();
            $cuti->keterangan1 = $request->input('keterangan1');
            $cuti->save();
        } elseif (Auth::user()->hasRole('KEPALA BAGIAN') && $cuti->user->hasRole('KEPALA UNIT')) {
            $cuti->approve_1 = 1;
            $cuti->approved_by_1 = Auth::id();
            $cuti->keterangan1 = $request->input('keterangan1');
            $cuti->save();
        } elseif (Auth::user()->hasRole('DIREKTUR') && $cuti->user->hasRole('KEPALA BAGIAN')) {
            $cuti->approve_1 = 1;
            $cuti->approved_by_1 = Auth::id();
            $cuti->keterangan1 = $request->input('keterangan1');
            $cuti->save();
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve cuti.');
        }

        return redirect()->back()->with('success', 'Cuti telah diapprove.');
    }

    public function rejectCuti1(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        // Logika reject cuti oleh Kepala Unit, Kepala Bagian, atau Direktur
        if (Auth::user()->hasRole('KEPALA UNIT') && Auth::user()->unit == $cuti->user->unit) {
            $cuti->approve_1 = -1; // Menolak
            $cuti->approved_by_1 = Auth::id();
            $cuti->keterangan1 = $request->input('keterangan1');
            $cuti->save();
        } elseif (Auth::user()->hasRole('KEPALA BAGIAN') && $cuti->user->hasRole('KEPALA UNIT')) {
            $cuti->approve_1 = -1;
            $cuti->approved_by_1 = Auth::id();
            $cuti->keterangan1 = $request->input('keterangan1');
            $cuti->save();
        } elseif (Auth::user()->hasRole('DIREKTUR') && $cuti->user->hasRole('KEPALA BAGIAN')) {
            $cuti->approve_1 = -1;
            $cuti->approved_by_1 = Auth::id();
            $cuti->keterangan1 = $request->input('keterangan1');
            $cuti->save();
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak cuti.');
        }

        return redirect()->back()->with('success', 'Cuti telah ditolak.');
    }
    public function approveCuti2(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        // Logika approve cuti oleh HRD
        if (Auth::user()->hasRole('HRD')) {
            $cuti->approve_2 = 1; // Set approve_2 jadi 1 (approve)
            $cuti->approved_by_2 = Auth::id(); // Simpan siapa yang meng-approve
            $cuti->keterangan2 = $request->input('keterangan2'); // Alasan/keterangan approve dari HRD
            $cuti->save();

            return redirect()->back()->with('success', 'Cuti telah diapprove oleh HRD.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve cuti.');
        }
    }
    public function rejectCuti2(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        // Logika reject cuti oleh HRD
        if (Auth::user()->hasRole('HRD')) {
            $cuti->approve_2 = -1; // Set approve_2 jadi -1 (reject)
            $cuti->approved_by_2 = Auth::id(); // Simpan siapa yang menolak
            $cuti->keterangan2 = $request->input('keterangan2'); // Alasan/keterangan reject dari HRD
            $cuti->save();

            return redirect()->back()->with('success', 'Cuti telah ditolak oleh HRD.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak cuti.');
        }
    }
    public function viewCutiApproval1()
    {
        $user = auth()->user();

        // Ambil data cuti dari karyawan yang berada di unit yang sama dengan Kepala Unit / Kepala Bagian / Direktur
        $cutiKaryawan = Cuti::with('user')
            ->whereHas('user', function ($query) use ($user) {
                if ($user->hasRole('KEPALA UNIT')) {
                    $query->where('unit', $user->unit); // Kepala Unit, ambil karyawan yang satu unit
                } elseif ($user->hasRole('KEPALA BAGIAN')) {
                    $query->where('unit', $user->unit)->whereHas('roles', function ($q) {
                        $q->where('name', 'KEPALA UNIT'); // Kepala Bagian, ambil Kepala Unit
                    });
                } elseif ($user->hasRole('DIREKTUR')) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', 'KEPALA BAGIAN'); // Direktur, ambil Kepala Bagian
                    });
                }
            })
            ->where('approve_1', 0) // Hanya cuti yang belum diapprove oleh kepala unit/bagian
            ->get();

        // Ambil data history cuti
        $cutiHistory = Cuti::with('user')
            ->where('approve_1', '!=', 0) // History yang sudah di-approve/rejected
            ->whereHas('user', function ($query) use ($user) {
                if ($user->hasRole('KEPALA UNIT')) {
                    $query->where('unit', $user->unit); // Kepala Unit, ambil karyawan yang satu unit
                } elseif ($user->hasRole('KEPALA BAGIAN')) {
                    $query->where('unit', $user->unit)->whereHas('roles', function ($q) {
                        $q->where('name', 'KEPALA UNIT'); // Kepala Bagian, ambil Kepala Unit
                    });
                } elseif ($user->hasRole('DIREKTUR')) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', 'KEPALA BAGIAN'); // Direktur, ambil Kepala Bagian
                    });
                }
            })
            ->get();

        return view('cuti.approval1', compact('cutiKaryawan', 'cutiHistory'));
    }
    public function viewCutiHRD()
    {
        // Ambil data cuti yang butuh approval 2 oleh HRD
        $cutiBelumDisetujui = Cuti::where('approve_1', 1) // Hanya cuti yang sudah di-approve oleh kepala unit
            ->where('approve_2', 0)
            ->get();

        // Ambil data cuti yang sudah di-approve oleh HRD (History)
        $cutiDisetujui = Cuti::where('approve_2', 1) // Cuti yang sudah diapprove HRD
            ->orWhere('approve_2', -1) // Cuti yang ditolak oleh HRD (dianggap history juga)
            ->get();

        return view('cuti.approval2', compact('cutiBelumDisetujui', 'cutiDisetujui'));
    }


    //DATANG TERLAMBAT
    public function approveDatangTerlambat1(Request $request, $id)
    {
        $datangTerlambat = DatangTerlambat::findOrFail($id);

        // Logika approve datang terlambat oleh Kepala Unit, Kepala Bagian, atau Direktur
        if (Auth::user()->hasRole('KEPALA UNIT') && Auth::user()->unit == $datangTerlambat->karyn->unit) {
            $datangTerlambat->app_1 = 1;
            $datangTerlambat->approve_atasan = Auth::id();
            $datangTerlambat->keterangan1 = $request->input('keterangan');
            $datangTerlambat->save();
        } elseif (Auth::user()->hasRole('KEPALA BAGIAN') && $datangTerlambat->karyawan->hasRole('KEPALA UNIT')) {
            $datangTerlambat->app_1 = 1;
            $datangTerlambat->approve_atasan = Auth::id();
            $datangTerlambat->keterangan1 = $request->input('keterangan');
            $datangTerlambat->save();
        } elseif (Auth::user()->hasRole('DIREKTUR') && $datangTerlambat->karyawan->hasRole('KEPALA BAGIAN')) {
            $datangTerlambat->app_1 = 1;
            $datangTerlambat->approve_atasan = Auth::id();
            $datangTerlambat->keterangan1 = $request->input('keterangan');
            $datangTerlambat->save();
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve datang terlambat.');
        }

        return redirect()->back()->with('success', 'Datang terlambat telah diapprove.');
    }

    public function rejectDatangTerlambat1(Request $request, $id)
    {
        $datangTerlambat = DatangTerlambat::findOrFail($id);

        // Logika reject datang terlambat oleh Kepala Unit, Kepala Bagian, atau Direktur
        if (Auth::user()->hasRole('KEPALA UNIT') && Auth::user()->unit == $datangTerlambat->karyn->unit) {
            $datangTerlambat->app_1 = -1; // Menolak
            $datangTerlambat->approve_atasan = Auth::id();
            $datangTerlambat->keterangan1 = $request->input('keterangan');
            $datangTerlambat->save();
        } elseif (Auth::user()->hasRole('KEPALA BAGIAN') && $datangTerlambat->karyawan->hasRole('KEPALA UNIT')) {
            $datangTerlambat->app_1 = -1;
            $datangTerlambat->approve_atasan = Auth::id();
            $datangTerlambat->keterangan1 = $request->input('keterangan');
            $datangTerlambat->save();
        } elseif (Auth::user()->hasRole('DIREKTUR') && $datangTerlambat->karyawan->hasRole('KEPALA BAGIAN')) {
            $datangTerlambat->app_1 = -1;
            $datangTerlambat->approve_atasan = Auth::id();
            $datangTerlambat->keterangan1 = $request->input('keterangan');
            $datangTerlambat->save();
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak datang terlambat.');
        }

        return redirect()->back()->with('success', 'Datang terlambat telah ditolak.');
    }
    public function viewDatangTerlambatApproval1()
    {
        $user = auth()->user();

        // Ambil data datang terlambat dari karyawan yang berada di unit yang sama dengan Kepala Unit / Kepala Bagian / Direktur
        $datangTerlambatKaryawan = DatangTerlambat::with('karyn')
            ->whereHas('karyn', function ($query) use ($user) {
                if ($user->hasRole('KEPALA UNIT')) {
                    $query->where('unit', $user->unit); // Kepala Unit, ambil karyawan yang satu unit
                } elseif ($user->hasRole('KEPALA BAGIAN')) {
                    $query->where('unit', $user->unit)->whereHas('roles', function ($q) {
                        $q->where('name', 'KEPALA UNIT'); // Kepala Bagian, ambil Kepala Unit
                    });
                } elseif ($user->hasRole('DIREKTUR')) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', 'KEPALA BAGIAN'); // Direktur, ambil Kepala Bagian
                    });
                }
            })
            ->where('app_1', 0) // Hanya datang terlambat yang belum diapprove oleh kepala unit/bagian
            ->get();

        // Ambil data history datang terlambat
        $datangTerlambatHistory = DatangTerlambat::with('karyn')
            ->where('app_1', '!=', 0) // History yang sudah di-approve/rejected
            ->whereHas('karyn', function ($query) use ($user) {
                if ($user->hasRole('KEPALA UNIT')) {
                    $query->where('unit', $user->unit); // Kepala Unit, ambil karyawan yang satu unit
                } elseif ($user->hasRole('KEPALA BAGIAN')) {
                    $query->where('unit', $user->unit)->whereHas('roles', function ($q) {
                        $q->where('name', 'KEPALA UNIT'); // Kepala Bagian, ambil Kepala Unit
                    });
                } elseif ($user->hasRole('DIREKTUR')) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', 'KEPALA BAGIAN'); // Direktur, ambil Kepala Bagian
                    });
                }
            })
            ->get();

        return view('datang_terlambat.approval1', compact('datangTerlambatKaryawan', 'datangTerlambatHistory'));
    }
    public function approveDatangTerlambat2(Request $request, $id)
    {
        $datangTerlambat = DatangTerlambat::findOrFail($id);

        // Logika approve oleh SDI (HRD)
        if (Auth::user()->hasRole('HRD')) {
            $datangTerlambat->app_2 = 1; // Set app_2 jadi 1 (approve)
            $datangTerlambat->approve_sdi = Auth::id(); // Simpan siapa yang meng-approve
            $datangTerlambat->keterangan2 = $request->input('keterangan2'); // Alasan/keterangan approve dari SDI (HRD)
            $datangTerlambat->save();

            return redirect()->back()->with('success', 'Pengajuan datang terlambat telah diapprove oleh SDI.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve pengajuan datang terlambat.');
        }
    }
    public function rejectDatangTerlambat2(Request $request, $id)
    {
        $datangTerlambat = DatangTerlambat::findOrFail($id);

        // Logika reject oleh SDI (HRD)
        if (Auth::user()->hasRole('HRD')) {
            $datangTerlambat->app_2 = -1; // Set app_2 jadi -1 (reject)
            $datangTerlambat->approve_sdi = Auth::id(); // Simpan siapa yang menolak
            $datangTerlambat->keterangan2 = $request->input('keterangan2'); // Alasan/keterangan reject dari SDI (HRD)
            $datangTerlambat->save();

            return redirect()->back()->with('success', 'Pengajuan datang terlambat telah ditolak oleh SDI.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak pengajuan datang terlambat.');
        }
    }
    public function viewDatangTerlambatHRD()
    {
        // Ambil data datang terlambat yang butuh approval oleh SDI (HRD)
        $datangTerlambatBelumDisetujui = DatangTerlambat::where('app_1', 1) // Hanya yang sudah diapprove oleh approve_1
            ->where('app_2', 0) // Yang belum diapprove oleh SDI
            ->get();

        // Ambil data datang terlambat yang sudah di-approve atau ditolak oleh SDI (HRD)
        $datangTerlambatDisetujui = DatangTerlambat::where('app_2', 1) // Sudah diapprove SDI
            ->orWhere('app_2', -1) // Ditolak oleh SDI
            ->get();

        return view('datang_terlambat.approval_sdi', compact('datangTerlambatBelumDisetujui', 'datangTerlambatDisetujui'));
    }
}
