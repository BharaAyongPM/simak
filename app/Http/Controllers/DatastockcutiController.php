<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use App\Models\StokCuti;
use App\Models\User;
use Illuminate\Http\Request;

class DatastockcutiController extends Controller
{
    // Menampilkan daftar stok cuti karyawan
    public function index()
    {
        $stocks = StokCuti::with('user', 'jenisCuti')->get(); // Ambil data dengan relasi user dan jenis cuti
        $users = User::all(); // Ambil semua data user
        $jenisCutis = JenisCuti::all(); // Ambil semua data jenis cuti

        return view('datastockcuti.index', compact('stocks', 'users', 'jenisCutis'));
    }

    // Menyimpan data stok cuti baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'awal_cuti' => 'required|date',
            'akhir_cuti' => 'required|date|after_or_equal:awal_cuti',
            'jumlah' => 'required|integer|min:1',
            'pakai' => 'required|integer|min:0',
            'sisa' => 'required|integer|min:0',
            'tukar' => 'required|integer|min:0',
            'jenis_cuti' => 'required|exists:jenis_cuti,id',
        ]);

        // Simpan data stok cuti
        StokCuti::create([
            'user_id' => $request->user_id,
            'awal_cuti' => $request->awal_cuti,
            'akhir_cuti' => $request->akhir_cuti,
            'jumlah' => $request->jumlah,
            'pakai' => $request->pakai,
            'sisa' => $request->sisa,
            'tukar' => $request->tukar,
            'jenis_cuti' => $request->jenis_cuti,
        ]);

        return redirect()->route('datastockcuti.index')->with('success', 'Stok cuti berhasil ditambahkan.');
    }

    // Mengupdate data stok cuti
    public function update(Request $request, $id)
    {
        $stock = StokCuti::findOrFail($id);

        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'awal_cuti' => 'required|date',
            'akhir_cuti' => 'required|date|after_or_equal:awal_cuti',
            'jumlah' => 'required|integer|min:1',
            'pakai' => 'required|integer|min:0',
            'sisa' => 'required|integer|min:0',
            'tukar' => 'required|integer|min:0',
            'jenis_cuti' => 'required|exists:jenis_cuti,id',
        ]);

        // Update data stok cuti
        $stock->update([
            'user_id' => $request->user_id,
            'awal_cuti' => $request->awal_cuti,
            'akhir_cuti' => $request->akhir_cuti,
            'jumlah' => $request->jumlah,
            'pakai' => $request->pakai,
            'sisa' => $request->sisa,
            'tukar' => $request->tukar,
            'jenis_cuti' => $request->jenis_cuti,
        ]);

        return redirect()->route('datastockcuti.index')->with('success', 'Stok cuti berhasil diperbarui.');
    }

    // Menghapus data stok cuti
    public function destroy($id)
    {
        $stock = StokCuti::findOrFail($id);
        $stock->delete();

        return redirect()->route('datastockcuti.index')->with('success', 'Stok cuti berhasil dihapus.');
    }
    public function storeForAll(Request $request)
    {
        // Validasi input
        $request->validate([
            'awal_cuti' => 'required|date',
            'akhir_cuti' => 'required|date|after_or_equal:awal_cuti',
            'jumlah' => 'required|integer|min:1',
            'jenis_cuti' => 'required|exists:jenis_cuti,id',
        ]);

        // Ambil semua karyawan dari database
        $users = User::all();

        // Tambahkan stok cuti untuk setiap karyawan
        foreach ($users as $user) {
            StokCuti::create([
                'user_id' => $user->id,
                'awal_cuti' => $request->awal_cuti,
                'akhir_cuti' => $request->akhir_cuti,
                'jumlah' => $request->jumlah,
                'pakai' => 0, // Set nilai default 'pakai' sebagai 0
                'sisa' => $request->jumlah, // Sisa cuti diisi dengan jumlah cuti awal
                'tukar' => 0, // Set nilai default 'tukar' sebagai 0
                'jenis_cuti' => $request->jenis_cuti,
            ]);
        }

        return redirect()->route('datastockcuti.index')->with('success', 'Stok cuti berhasil ditambahkan untuk semua karyawan.');
    }
    public function edit($id)
    {
        // Ambil data stok cuti berdasarkan ID
        $stock = StokCuti::findOrFail($id);

        // Kembalikan data stok cuti dalam format JSON untuk digunakan di AJAX
        return response()->json($stock);
    }
}
