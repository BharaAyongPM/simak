<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Models\Absensi;
use App\Models\Bag;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\KalenderKerja;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalKaryawan = User::count();
        $totalAbsensi = Absensi::count();

        // Ambil semua data absensi
        $absensiTerbaru = Absensi::with('karyn')->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact('totalKaryawan', 'totalAbsensi', 'absensiTerbaru'));
    }
    // Menampilkan daftar karyawan
    public function listKaryawan()
    {
        $karyawans = User::where('role', '!=', 'admin')->get(); // Mengambil semua karyawan selain admin
        return view('admin.karyawan.list', compact('karyawans'));
    }

    // Menampilkan form untuk membuat karyawan baru
    public function createKaryawan()
    {
        return view('admin.karyawan.create');
    }

    // Menyimpan data karyawan baru
    public function storeKaryawan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.karyawan.list')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit karyawan
    public function editKaryawan($id)
    {
        $karyawan = User::find($id);
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    // Memperbarui data karyawan
    public function updateKaryawan(Request $request, $id)
    {
        $karyawan = User::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $karyawan->id,
            'role' => 'required|string',
        ]);

        $karyawan->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.karyawan.list')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    // Menghapus karyawan
    public function deleteKaryawan($id)
    {
        $karyawan = User::find($id);
        $karyawan->delete();

        return redirect()->route('admin.karyawan.list')->with('success', 'Karyawan berhasil dihapus.');
    }

    // Cek Absensi Karyawan
    public function cekAbsensi(Request $request)
    {
        $query = Absensi::query();

        // Filter berdasarkan karyawan
        if ($request->has('karyawan_id') && $request->karyawan_id != '') {
            $query->where('karyawan', $request->karyawan_id); // Gunakan kolom 'karyawan' yang sesuai
        }

        // Filter berdasarkan satu tanggal atau gunakan hari ini jika tidak ada filter tanggal
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            // Jika tidak ada filter tanggal, tampilkan data absensi hari ini
            $query->whereDate('tanggal', Carbon::today());
        }

        // Mengambil data absensi berdasarkan filter
        $absensis = $query->with('karyn')->get();

        // Mengambil semua karyawan untuk ditampilkan di dropdown filter
        $karyawanList = \App\Models\User::all(); // Mengambil semua data karyawan

        return view('admin.absensi.cek', compact('absensis', 'karyawanList'));
    }
    // Rekap Absensi Karyawan (berdasarkan karyawan atau periode)
    public function rekapAbsensi(Request $request)
    {
        // Ambil filter bagian, unit, tanggal awal, dan tanggal akhir dari request
        $bagianId = $request->input('bagian_id');
        $unitId = $request->input('unit_id');
        $tanggalAwal = $request->input('tanggal_awal', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        // Batasi tanggal akhir maksimal hingga hari ini (untuk mencegah melihat masa depan)
        if (Carbon::parse($tanggalAkhir)->gt(Carbon::now())) {
            $tanggalAkhir = Carbon::now()->toDateString();
        }

        // Query untuk mendapatkan data karyawan yang sesuai dengan filter bagian dan unit
        $query = User::query()
            ->with(['bagian', 'unt']) // Relasi untuk bagian dan unit
            ->when($bagianId, function ($q) use ($bagianId) {
                $q->where('divisi', $bagianId); // Filter berdasarkan bagian
            })
            ->when($unitId, function ($q) use ($unitId) {
                $q->where('unit', $unitId); // Filter berdasarkan unit
            });

        // Pagination DataTables: Ambil jumlah per halaman dan halaman saat ini
        $length = $request->input('length', 10); // Jumlah data per halaman
        $start = $request->input('start', 0); // Mulai dari data ke berapa
        $page = ($start / $length) + 1; // Hitung halaman berdasarkan 'start'

        // Dapatkan data karyawan sesuai paginasi dan filter
        $users = $query->paginate($length, ['*'], 'page', $page);

        // Array untuk menyimpan data yang akan ditampilkan di tabel
        $data = [];

        // Loop untuk setiap karyawan yang diambil dari query
        foreach ($users as $index => $user) {
            // Baris untuk setiap karyawan
            $row = [
                'no' => $index + 1 + ($users->currentPage() - 1) * $users->perPage(),
                'karyawan_name' => $user->name,
                'bagian_name' => $user->bagian->nama_bagian ?? '-',
                'unit' => $user->unt->unit ?? '-',
            ];

            // Loop melalui setiap tanggal dalam periode yang dipilih
            $currentDate = Carbon::parse($tanggalAwal);
            while ($currentDate->lte(Carbon::parse($tanggalAkhir))) {
                // Cek apakah di kalender kerja tanggal ini adalah "Off"
                $kalenderKerja = KalenderKerja::where('tanggal', $currentDate->toDateString())
                    ->where('karyawan', $user->id) // Atau sesuai filter kalender kerja
                    ->first();

                if ($kalenderKerja && $kalenderKerja->shift == 'OFF') {
                    // Jika di kalender kerja shift-nya Off, tampilkan Off
                    $row['tanggal_' . $currentDate->format('d')] = 'OFF';
                } else {
                    // Cek absensi berdasarkan tanggal dan karyawan
                    $absen = Absensi::where('karyawan', $user->id)
                        ->where('tanggal', $currentDate->toDateString())
                        ->first();

                    // Jika absen tidak ditemukan, cek apakah karyawan cuti atau izin
                    if (!$absen) {
                        // Cek apakah karyawan cuti pada tanggal ini
                        $cuti = Cuti::where('user_id', $user->id)
                            ->whereDate('tanggal_mulai', '<=', $currentDate)
                            ->whereDate('tanggal_selesai', '>=', $currentDate)
                            ->first();

                        // Cek apakah karyawan izin pada tanggal ini
                        $izin = Izin::where('user_id', $user->id)
                            ->whereDate('tanggal_mulai', '<=', $currentDate)
                            ->whereDate('tanggal_selesai', '>=', $currentDate)
                            ->first();

                        if ($cuti) {
                            $row['tanggal_' . $currentDate->format('d')] = 'Cuti';
                        } elseif ($izin) {
                            $row['tanggal_' . $currentDate->format('d')] = 'Izin';
                        } else {
                            $row['tanggal_' . $currentDate->format('d')] = 'Alpa';
                        }
                    } else {
                        // Jika absen ditemukan, tampilkan shift
                        $row['tanggal_' . $currentDate->format('d')] = $absen->shift;
                    }
                }

                $currentDate->addDay(); // Tambahkan satu hari
            }

            // Tambahkan baris ke dalam array data
            $data[] = $row;
        }

        // Jika ini permintaan AJAX dari DataTables
        if ($request->ajax()) {
            return response()->json([
                'data' => $data,
                'recordsTotal' => $users->total(),
                'recordsFiltered' => $users->total(),
            ]);
        }

        // Mengambil data semua bagian dan unit untuk dropdown filter
        $bagians = Bag::all(); // Asumsi model 'Bag' untuk tabel 'bag'
        $units = Unit::all(); // Asumsi model 'Unit' untuk tabel unit

        // Return view dengan data yang dibutuhkan
        return view('admin.absensi.rekap', compact('bagians', 'units', 'tanggalAwal', 'tanggalAkhir'));
    }


    public function getUnitsByBagian($bagianId)
    {
        // Ambil unit berdasarkan bagian yang dipilih
        $units = Unit::where('bagian', $bagianId)->get(); // Sesuaikan dengan field yang menghubungkan unit dan bagian

        return response()->json($units);
    }





    // Export Absensi Karyawan ke Excel
    public function exportAbsensi(Request $request)
    {
        ini_set('max_execution_time', 300);
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);
        $bagian_id = $request->input('bagian_id');
        $unit_id = $request->input('unit_id');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // Debugging log untuk memeriksa input
        Log::info('Tanggal Awal: ' . $tanggal_awal);
        Log::info('Tanggal Akhir: ' . $tanggal_akhir);
        if (!$tanggal_awal || !$tanggal_akhir) {
            return back()->with('error', 'Tanggal awal dan akhir harus diisi.');
        }

        $filename = 'rekap-absensi-' . \Carbon\Carbon::parse($tanggal_awal)->format('d-m-Y') . '-sampai-' . \Carbon\Carbon::parse($tanggal_akhir)->format('d-m-Y') . '.xlsx';

        return Excel::download(new AbsensiExport($bagian_id, $unit_id, $tanggal_awal, $tanggal_akhir), $filename);
    }

    // Menampilkan halaman User Management (menambah atau menghapus role pada user)
    public function userManagement()
    {
        $users = User::all();
        $roles = \App\Models\Role::all(); // Mengambil semua role yang ada
        return view('admin.user_management.index', compact('users', 'roles'));
    }

    // Mengubah Role User
    public function updateUserRole(Request $request, $userId)
    {
        $user = User::find($userId);

        // Menyinkronkan role yang dipilih dengan user
        $user->roles()->sync($request->roles);

        return redirect()->back()->with('success', 'Role user berhasil diperbarui.');
    }
}
