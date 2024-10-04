<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use Illuminate\Http\Request;

class JeniscutiController extends Controller
{
    // Method untuk menampilkan daftar jenis cuti (index)
    public function index()
    {
        $jenis_cutis = JenisCuti::all(); // Ambil semua data jenis cuti
        return view('jeniscuti.index', compact('jenis_cutis'));
    }

    // Method untuk menyimpan jenis cuti baru (store)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
        ]);

        // Simpan jenis cuti baru
        JenisCuti::create([
            'nama' => $request->nama,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('jeniscuti.index')->with('success', 'Jenis Cuti berhasil ditambahkan.');
    }

    // Method untuk mengambil data jenis cuti (edit)
    public function edit($id)
    {
        $jeniscuti = JenisCuti::findOrFail($id); // Cari jenis cuti berdasarkan ID

        return response()->json($jeniscuti); // Kembalikan data dalam bentuk JSON
    }

    // Method untuk memperbarui jenis cuti (update)
    public function update(Request $request, $id)
    {
        $jeniscuti = JenisCuti::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
        ]);

        // Perbarui data jenis cuti
        $jeniscuti->update([
            'nama' => $request->nama,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('jeniscuti.index')->with('success', 'Jenis Cuti berhasil diperbarui.');
    }

    // Method untuk menghapus jenis cuti (destroy)
    public function destroy($id)
    {
        $jeniscuti = JenisCuti::findOrFail($id);
        $jeniscuti->delete();

        return redirect()->route('jeniscuti.index')->with('success', 'Jenis Cuti berhasil dihapus.');
    }
}
