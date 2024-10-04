<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    // Method untuk menampilkan daftar shift (index)
    public function index()
    {
        $shifts = Shift::all(); // Ambil semua data shift
        return view('shifts.index', compact('shifts'));
    }

    // Method untuk menyimpan data shift baru (store)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|unique:shift,nama',
            'masuk' => 'required',
            'pulang' => 'required|after:masuk',
        ]);

        // Simpan shift baru
        Shift::create([
            'nama' => $request->nama,
            'masuk' => $request->masuk,
            'pulang' => $request->pulang,
        ]);

        return redirect()->route('shifts.index')->with('success', 'Shift berhasil ditambahkan.');
    }

    // Method untuk mengambil data shift (edit)
    public function edit($id)
    {
        $shift = Shift::findOrFail($id); // Cari shift berdasarkan ID

        return response()->json($shift); // Kembalikan data dalam bentuk JSON
    }

    // Method untuk memperbarui data shift (update)
    public function update(Request $request, $id)
    {
        try {
            // Cari shift berdasarkan ID
            $shift = Shift::findOrFail($id);

            // Validasi input
            $request->validate([
                'nama' => 'required|string|max:255',
                'masuk' => 'required',
                'pulang' => 'required|after:masuk',
            ]);

            // Perbarui data shift
            $shift->update([
                'nama' => $request->nama,
                'masuk' => $request->masuk,
                'pulang' => $request->pulang,
            ]);

            return redirect()->route('shifts.index')->with('success', 'Shift berhasil diperbarui.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangkap dan kembalikan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method untuk menghapus data shift (destroy)
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->delete();

        return redirect()->route('shifts.index')->with('success', 'Shift berhasil dihapus.');
    }
}
