<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
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
        if ($request->has('karyawan_id')) {
            $query->where('karyawan', $request->karyawan_id); // Gunakan kolom 'karyawan' yang sesuai
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
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

        // Default ke bulan saat ini jika tidak ada tanggal yang dipilih
        $tanggalAwal = $request->input('tanggal_awal', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        // Jika ingin filter berdasarkan karyawan
        if ($request->has('karyawan_id')) {
            $query->where('user_id', $request->karyawan_id);
        }

        // Filter berdasarkan tanggal
        $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);

        $absensis = $query->with('karyn')->paginate(10); // Tambahkan paginate untuk pagination Laravel

        // Mengirim user data untuk filter
        $users = User::all();

        return view('admin.absensi.rekap', compact('absensis', 'users', 'tanggalAwal', 'tanggalAkhir'));
    }

    // Export Absensi Karyawan ke Excel
    public function exportAbsensi(Request $request)
    {
        $karyawan_id = $request->input('karyawan_id');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        return Excel::download(new AbsensiExport($karyawan_id, $tanggal_awal, $tanggal_akhir), 'absensi.xlsx');
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
