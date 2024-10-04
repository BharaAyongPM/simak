<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use Illuminate\Http\Request;

class BagianController extends Controller
{
    // Method untuk menampilkan daftar bagian (index)
    public function index()
    {
        $bagians = Bag::all(); // Ambil semua data bagian
        return view('bagian.index', compact('bagians'));
    }

    // Method untuk menyimpan data bagian baru (store)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_bagian' => 'required|string|max:255',
        ]);

        // Simpan bagian baru
        Bag::create([
            'nama_bagian' => $request->nama_bagian,
        ]);

        return redirect()->route('bagian.index')->with('success', 'Bagian berhasil ditambahkan.');
    }

    // Method untuk mengambil data bagian (edit)
    public function edit($id)
    {
        $bagian = Bag::findOrFail($id); // Cari bagian berdasarkan ID

        return response()->json($bagian); // Kembalikan data dalam bentuk JSON
    }

    // Method untuk memperbarui data bagian (update)
    public function update(Request $request, $id)
    {
        $bagian = Bag::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama_bagian' => 'required|string|max:255',
        ]);

        // Perbarui data bagian
        $bagian->update([
            'nama_bagian' => $request->nama_bagian,
        ]);

        return redirect()->route('bagian.index')->with('success', 'Bagian berhasil diperbarui.');
    }

    // Method untuk menghapus data bagian (destroy)
    public function destroy($id)
    {
        $bagian = Bag::findOrFail($id);
        $bagian->delete();

        return redirect()->route('bagian.index')->with('success', 'Bagian berhasil dihapus.');
    }
}
