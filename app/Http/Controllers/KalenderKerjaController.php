<?php

namespace App\Http\Controllers;

use App\Models\KalenderKerja;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KalenderKerjaImport;
use App\Models\Shift;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Log;

class KalenderKerjaController extends Controller
{
    // Menampilkan halaman utama Kalender Kerja

    public function index(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = auth()->user();

        // Mendapatkan filter tanggal dari request atau menggunakan tanggal bulan ini
        $tanggalAwal = $request->input('tanggal_awal', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        // Mengambil semua karyawan di divisi yang sama dengan user yang sedang login
        $karyawanDivisi = \App\Models\User::where('unit', $user->unit)->get();

        // Mengambil data kalender kerja berdasarkan filter tanggal dan divisi yang sama
        $kalenderKerja = KalenderKerja::whereIn('karyawan', $karyawanDivisi->pluck('id'))
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->get()
            ->groupBy('karyawan'); // Group by karyawan agar mudah ditampilkan nanti

        // Mengambil daftar shift yang tersedia
        $shifts = \App\Models\Shift::all(); // Pastikan ada model Shift

        return view('kalender_kerja.index', compact('kalenderKerja', 'tanggalAwal', 'tanggalAkhir', 'karyawanDivisi', 'shifts'));
    }


    public function uploadKalenderKerja(Request $request)
    {
        // Validasi file harus berupa Excel
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date'
        ]);

        // Cek apakah file diunggah dengan benar
        if (!$request->hasFile('import_file')) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        // Proses impor file Excel
        $path = $request->file('import_file')->getRealPath();
        $data = Excel::toArray([], $path); // Membaca semua data dari Excel

        $tanggalAwal = Carbon::parse($request->input('tanggal_awal'));
        $tanggalAkhir = Carbon::parse($request->input('tanggal_akhir'));

        // Iterasi melalui baris di Excel, mulai dari baris ke-2 (baris pertama adalah header)
        foreach ($data[0] as $key => $row) {
            if ($key == 0) {
                // Abaikan baris pertama karena ini adalah header
                continue;
            }

            // Cek apakah baris tersebut kosong (tidak ada ID atau Nama)
            if (empty($row[1]) || empty($row[2])) {
                continue; // Skip baris ini jika ID atau Nama karyawan kosong
            }

            $karyawanId = $row[1]; // ID karyawan dari kolom kedua
            $namaKaryawan = $row[2]; // Nama karyawan dari kolom ketiga

            Log::info('Proses penyimpanan: ', ['karyawan_id' => $karyawanId, 'nama' => $namaKaryawan]);

            // Simpan shift untuk setiap tanggal
            for ($i = 1; $i <= $tanggalAkhir->diffInDays($tanggalAwal) + 1; $i++) {
                $tanggal = $tanggalAwal->copy()->addDays($i - 1)->toDateString();

                // Cek apakah shift valid untuk tanggal ini
                $shiftNama = $row[2 + $i] ?? null; // Index 2 + $i untuk mengakses kolom tanggal_1, tanggal_2, dll.

                if (!$shiftNama) {
                    continue; // Skip jika shift tidak ada
                }

                // Cari shift di database
                $shift = Shift::where('nama', $shiftNama)->first();

                if ($shift) {
                    Log::info('Shift yang diambil dari Excel: ', ['tanggal' => $tanggal, 'shift' => $shiftNama]);

                    KalenderKerja::updateOrCreate(
                        [
                            'tanggal' => $tanggal,
                            'karyawan' => $karyawanId
                        ],
                        [
                            'shift' => $shift->nama, // Nama shift dari kolom Excel
                            'jam_masuk' => $shift->masuk, // Jam masuk diambil dari tabel Shift
                            'jam_pulang' => $shift->pulang, // Jam pulang diambil dari tabel Shift
                            'divisi' => auth()->user()->bag->id_bagian, // Divisi user yang login
                            'unit' => auth()->user()->unt->id // Unit user yang login
                        ]
                    );
                } else {
                    Log::info('Shift tidak ditemukan untuk: ', ['shift' => $shiftNama]);
                }
            }
        }

        return redirect()->back()->with('success', 'Kalender kerja berhasil diunggah.');
    }


    public function updateShift(Request $request)
    {
        $validated = $request->validate([
            'kalender_id' => 'required|exists:kalenderkerja,id',
            'shift' => 'required|string'
        ]);

        // Temukan entri kalender kerja
        $kalenderKerja = KalenderKerja::find($validated['kalender_id']);

        // Update shift
        $shift = Shift::where('nama', $validated['shift'])->first();
        if (!$shift) {
            return response()->json(['message' => 'Shift tidak ditemukan'], 400);
        }

        $kalenderKerja->shift = $shift->nama;
        $kalenderKerja->jam_masuk = $shift->masuk;
        $kalenderKerja->jam_pulang = $shift->pulang;
        $kalenderKerja->save();

        return response()->json(['message' => 'Shift berhasil diubah']);
    }
    public function indexKaryawan(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = auth()->user();
        Carbon::setLocale('id');  // Set locale ke Indonesia
        // Mendapatkan filter tanggal dari request atau menggunakan tanggal bulan ini
        $tanggalAwal = $request->input('tanggal_awal', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        // Mengambil data kalender kerja berdasarkan filter tanggal hanya untuk user yang sedang login
        $kalenderKerja = KalenderKerja::where('karyawan', $user->id)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->get();

        // Mengambil daftar shift yang tersedia untuk menampilkan shift terkait
        $shifts = \App\Models\Shift::all();

        // Mengembalikan view dengan data kalender kerja
        return view('kalender_kerja.karyawan', compact('kalenderKerja', 'tanggalAwal', 'tanggalAkhir', 'shifts'));
    }
    public function downloadTemplate(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = auth()->user();

        // Mendapatkan filter tanggal dari request atau menggunakan tanggal bulan ini
        $tanggalAwal = $request->input('tanggal_awal', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        // Mengambil semua karyawan di unit yang sama dengan user yang sedang login
        $karyawanDivisi = \App\Models\User::where('unit', $user->unit)->get();

        // Buat template Excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menentukan header tabel: ID, Nama, dan Tanggal (berdasarkan filter tanggal)
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID');
        $sheet->setCellValue('C1', 'Nama');

        // Generate tanggal secara dinamis berdasarkan filter
        $currentDate = Carbon::parse($tanggalAwal);
        $endDate = Carbon::parse($tanggalAkhir);
        $columnIndex = 'D';  // Kolom pertama untuk tanggal
        while ($currentDate <= $endDate) {
            $sheet->setCellValue($columnIndex . '1', 'tanggal_' . $currentDate->format('d'));
            $currentDate->addDay();
            $columnIndex++;
        }

        // Mengisi data karyawan
        $row = 2;  // Mulai dari baris kedua
        foreach ($karyawanDivisi as $index => $karyawan) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $karyawan->id);
            $sheet->setCellValue('C' . $row, $karyawan->name);

            // Tanggal diisi kosong untuk diisi oleh user nanti
            $currentDate = Carbon::parse($tanggalAwal);
            $columnIndex = 'D';  // Kolom pertama untuk tanggal
            while ($currentDate <= $endDate) {
                $sheet->setCellValue($columnIndex . $row, '');  // Kosongkan kolom shift
                $currentDate->addDay();
                $columnIndex++;
            }
            $row++;
        }

        // Simpan ke file Excel
        $fileName = 'template_kalender_kerja_' . $user->unit . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filePath);

        // Download file
        return response()->download($filePath);
    }
}
