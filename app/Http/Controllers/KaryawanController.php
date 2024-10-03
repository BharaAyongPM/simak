<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    // Menampilkan semua data karyawan (index)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil query dasar karyawan dengan relasi bagian dan unit
            $query = User::with(['bagian', 'unt']);

            // Tambahkan filter berdasarkan bagian jika ada
            if ($request->has('bagian_id') && $request->bagian_id) {
                $query->where('divisi', $request->bagian_id);
            }

            // Tambahkan filter berdasarkan unit jika ada
            if ($request->has('unit_id') && $request->unit_id) {
                $query->where('unit', $request->unit_id);
            }

            // Ambil data karyawan sesuai filter
            $karyawans = $query->get();

            // Gunakan DataTables untuk memformat data
            return DataTables::of($karyawans)
                ->addIndexColumn() // Kolom nomor urut
                ->addColumn('unit_name', function ($karyawan) {
                    // Cek apakah unit tersedia, jika tidak tampilkan '-'
                    return $karyawan->unit ? $karyawan->unt->unit : '-';
                })
                ->addColumn('actions', function ($karyawan) {
                    // Tombol aksi untuk edit dan hapus
                    return view('karyawan.partials.actions', compact('karyawan'))->render();
                })
                ->rawColumns(['actions']) // Supaya kolom actions tidak di-*escape*
                ->make(true);
        }

        // Ambil semua data bagian dan unit untuk filter dropdown
        $bagians = Bag::all();
        $units = Unit::all();

        return view('karyawan.index', compact('bagians', 'units'));
    }





    // Menyimpan data karyawan baru (store)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nik' => 'required|string|max:20',
            'jabatan' => 'required|string|max:100',
            'tgl_masuk' => 'required|date',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'kelamin' => 'required|in:laki-laki,perempuan',
            'agama' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'gaji' => 'required|numeric',
            'shift' => 'required|string|max:50',
            'unit' => 'required|string|max:100',
        ]);

        // Simpan karyawan baru ke tabel users
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'jabatan' => $request->jabatan,
            'tgl_masuk' => $request->tgl_masuk,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'kelamin' => $request->kelamin,
            'agama' => $request->agama,
            'tgl_lahir' => $request->tgl_lahir,
            'gaji' => $request->gaji,
            'shift' => $request->shift,
            'unit' => $request->unit,
            'level' => 'karyawan',
            'aktif' => 1, // Set karyawan sebagai aktif
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    // Mengupdate data karyawan yang sudah ada (update)
    public function update(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'required|string|max:20',
            'jabatan' => 'required|string|max:100',
            'tgl_masuk' => 'required|date',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'kelamin' => 'required|in:laki-laki,perempuan',
            'agama' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'gaji' => 'required|numeric',
            'shift' => 'required|string|max:50',
            'unit' => 'required|string|max:100',
        ]);

        // Update data karyawan
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'jabatan' => $request->jabatan,
            'tgl_masuk' => $request->tgl_masuk,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'kelamin' => $request->kelamin,
            'agama' => $request->agama,
            'tgl_lahir' => $request->tgl_lahir,
            'gaji' => $request->gaji,
            'shift' => $request->shift,
            'unit' => $request->unit,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate.');
    }

    // Menghapus data karyawan (delete)
    public function destroy(User $user)
    {
        // Hapus karyawan
        $user->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus');
    }
}
