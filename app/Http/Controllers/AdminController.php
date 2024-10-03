<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Bag;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $query = Absensi::query();

        // Filter berdasarkan divisi (bagian)
        if ($request->has('bagian_id') && $request->bagian_id) {
            $bagianId = $request->input('bagian_id');
            $query->whereHas('karyn', function ($q) use ($bagianId) {
                $q->where('divisi', $bagianId); // 'divisi' adalah kolom di tabel user yang mengarah ke 'id_bagian'
            });
        }

        // Filter berdasarkan unit (jika ada)
        if ($request->has('unit_id') && $request->unit_id) {
            $unitId = $request->input('unit_id');
            $query->whereHas('karyn', function ($q) use ($unitId) {
                $q->where('unit', $unitId); // 'unit' adalah nama kolom yang benar di tabel users
            });
        }

        // Filter berdasarkan tanggal awal dan akhir
        $tanggalAwal = $request->input('tanggal_awal', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());
        $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);

        // Ambil parameter dari DataTables
        $length = $request->input('length', 10); // Jumlah data per halaman
        $start = $request->input('start', 0); // Mulai dari data ke berapa
        $page = ($start / $length) + 1; // Hitung halaman berdasarkan 'start'

        // Ambil data absensi dengan paginasi yang sesuai dengan permintaan DataTables
        $absensis = $query->with(['karyn.bagian', 'karyn.unt'])->paginate($length, ['*'], 'page', $page);

        // Mengambil semua bagian dan unit untuk dropdown filter
        $bagians = Bag::all(); // Asumsi model 'Bag' untuk tabel 'bag'
        $units = Unit::all();  // Asumsi model 'Unit' untuk tabel unit

        // Kembalikan data JSON jika permintaan dari DataTables (server-side)
        if ($request->ajax()) {
            $data = [];
            foreach ($absensis as $index => $absensi) {
                $data[] = [
                    'no' => $index + 1 + ($absensis->currentPage() - 1) * $absensis->perPage(),
                    'tanggal' => $absensi->tanggal,
                    'karyawan_name' => $absensi->karyn->name ?? 'Data tidak ditemukan',
                    'bagian_name' => $absensi->karyn->bagian->nama_bagian ?? '-',
                    'unit' => $absensi->karyn->unt->unit ?? '-',
                    'shift' => $absensi->shift,
                    'jam' => $absensi->jam,
                    'jam_pulang' => $absensi->jam_pulang,
                    'lembur' => $absensi->lembur ?? '-',
                    'status' => $absensi->status ?? '-',
                    'keterangan' => $absensi->keterangan ?? '-',
                ];
            }

            return response()->json([
                'data' => $data,
                'recordsTotal' => $absensis->total(),
                'recordsFiltered' => $absensis->total(),
            ]);
        }

        return view('admin.absensi.rekap', compact('absensis', 'bagians', 'units', 'tanggalAwal', 'tanggalAkhir'));
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
        // Ambil data absensi berdasarkan filter
        $absensis = Absensi::whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir])
            ->with('user')
            ->get();

        // Buat dan ekspor file Excel
        return Excel::download(new AbsensiExport($absensis), 'rekap_absensi.xlsx');
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
