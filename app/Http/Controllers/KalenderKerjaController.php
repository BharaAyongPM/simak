<?php

namespace App\Http\Controllers;

use App\Models\KalenderKerja;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KalenderKerjaImport;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class KalenderKerjaController extends Controller
{
    // Menampilkan halaman utama Kalender Kerja
    public function index(Request $request)
    {
        // Mendapatkan filter tanggal dari request atau menggunakan tanggal bulan ini
        $tanggalAwal = $request->input('tanggal_awal', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        // Mengambil data kalender kerja berdasarkan filter tanggal dan karyawan
        $kalenderKerja = KalenderKerja::where('karyawan', auth()->id())
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->get();

        return view('kalender_kerja.index', compact('kalenderKerja', 'tanggalAwal', 'tanggalAkhir'));
    }

    // Mengunggah file Excel untuk mengisi data kalender kerja
    public function uploadKalenderKerja(Request $request)
    {
        // Validasi file harus berupa Excel
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls'
        ]);

        // Mengimpor data dari file Excel
        Excel::import(new KalenderKerjaImport, $request->file('import_file'));

        return redirect()->back()->with('success', 'Kalender kerja berhasil diunggah.');
    }
}
