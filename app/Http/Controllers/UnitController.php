<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // Method untuk menampilkan daftar unit (index)
    public function index()
    {
        $units = Unit::with('bag')->get(); // Ambil semua data unit beserta bagian
        $bagians = Bag::all(); // Ambil semua data bagian untuk dropdown
        return view('unit.index', compact('units', 'bagians'));
    }

    // Method untuk menyimpan data unit baru (store)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'bagian' => 'required|exists:bag,id_bagian', // Validasi ID bagian yang ada
            'unit' => 'required|string|max:255',
        ]);

        try {
            // Simpan unit baru
            Unit::create([
                'bagian' => $request->bagian,
                'unit' => $request->unit,
            ]);

            return redirect()->route('unit.index')->with('success', 'Unit berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Tangkap error dan kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->route('unit.index')->with('error', 'Gagal menambahkan unit: ' . $e->getMessage());
        }
    }

    // Method untuk mengambil data unit (edit)
    public function edit($id)
    {
        $unit = Unit::findOrFail($id); // Cari unit berdasarkan ID

        return response()->json($unit); // Kembalikan data dalam bentuk JSON
    }

    // Method untuk memperbarui data unit (update)
    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        // Validasi input
        $request->validate([
            'bagian' => 'required|exists:bag,id_bagian', // Validasi ID bagian yang ada
            'unit' => 'required|string|max:255',
        ]);

        // Perbarui data unit
        $unit->update([
            'bagian' => $request->bagian,
            'unit' => $request->unit,
        ]);

        return redirect()->route('unit.index')->with('success', 'Unit berhasil diperbarui.');
    }

    // Method untuk menghapus data unit (destroy)
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('unit.index')->with('success', 'Unit berhasil dihapus.');
    }
}
