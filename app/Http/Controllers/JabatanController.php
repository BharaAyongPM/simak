<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    // Method untuk menampilkan daftar jabatan (index)
    public function index()
    {
        $jabatans = Jabatan::all(); // Ambil semua data jabatan
        return view('jabatans.index', compact('jabatans'));
    }

    // Method untuk menyimpan data jabatan baru (store)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|unique:jabatan,nama',

        ]);

        // Simpan jabatan baru
        Jabatan::create([
            'nama' => $request->nama,

        ]);

        return redirect()->route('jabatans.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    // Method untuk memperbarui data jabatan (update)
    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|unique:jabatan,nama,' . $jabatan->id,

        ]);

        // Perbarui data jabatan
        $jabatan->update([
            'nama' => $request->nama,

        ]);

        return redirect()->route('jabatans.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    // Method untuk menghapus data jabatan (delete)
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatans.index')->with('success', 'Jabatan berhasil dihapus.');
    }
    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id); // Cari jabatan berdasarkan ID

        return response()->json($jabatan); // Kembalikan data dalam bentuk JSON
    }
}
