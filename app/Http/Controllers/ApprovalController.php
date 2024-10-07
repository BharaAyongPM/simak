<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function approve1(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);

        // Logika approve 1
        if (Auth::user()->role == 'KEPALA UNIT' && Auth::user()->unit == $izin->user->unit) {
            $izin->approve_1 = 1;
            $izin->approved_by_1 = Auth::id();
            $izin->keterangan1 = $request->input('keterangan1');
        } elseif (Auth::user()->role == 'KEPALA BAGIAN' && Auth::user()->unit == $izin->user->unit && $izin->user->role == 'KEPALA UNIT') {
            $izin->approve_1 = 1;
            $izin->approved_by_1 = Auth::id();
            $izin->keterangan1 = $request->input('keterangan1');
        } elseif (Auth::user()->role == 'DIREKTUR' && $izin->user->role == 'KEPALA BAGIAN') {
            $izin->approve_1 = 1;
            $izin->approved_by_1 = Auth::id();
            $izin->keterangan1 = $request->input('keterangan1');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve.');
        }

        $izin->save();

        return redirect()->back()->with('success', 'Izin telah diapprove oleh Approve 1.');
    }

    public function approve2(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);

        if ($izin->approve_1 != 1) {
            return redirect()->back()->with('error', 'Izin belum diapprove oleh Approve 1.');
        }

        if (Auth::user()->role == 'HRD') {
            $izin->approve_2 = 1;
            $izin->approved_by_2 = Auth::id();
            $izin->keterangan2 = $request->input('keterangan2');
            $izin->save();
            return redirect()->back()->with('success', 'Izin telah diapprove oleh Approve 2.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk approve.');
        }
    }
}
