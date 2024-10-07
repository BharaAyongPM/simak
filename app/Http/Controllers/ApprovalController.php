<?php

namespace App\Http\Controllers;

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

    public function approve2Index()
    {
        // Data izin yang belum diapprove oleh approve 2
        $izinBelumDisetujui = Izin::where('approve_1', 1)
            ->where('approve_2', 0)
            ->get();

        // Data izin yang sudah diapprove oleh approve 2 (History)
        $izinDisetujui = Izin::where('approve_2', 1)
            ->get();

        return view('izin.approval2', compact('izinBelumDisetujui', 'izinDisetujui'));
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

        // Ambil data lembur yang sudah di-approve oleh Kepala Unit (History)
        $lemburDisetujui = Lembur::where('approve_1', 1)
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
        $lemburDisetujui = Lembur::where('approve_2', 1)
            ->get();

        return view('lembur.approval2', compact('lemburBelumDisetujui', 'lemburDisetujui'));
    }
}
