<?php

namespace App\Http\Controllers;

use App\Models\Libur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LiburController extends Controller
{
    public function index()
    {
        $liburs = Libur::all(); // Ambil semua data hari libur dari database

        return view('libur.index', compact('liburs'));
    }

    // Method untuk menyimpan hari libur baru (store)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date|unique:liburs,tanggal', // Pastikan tanggal unik
            'keterangan' => 'required|string|max:255',
        ]);

        // Simpan hari libur baru
        Libur::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('libur.index')->with('success', 'Hari libur berhasil ditambahkan.');
    }

    // Method untuk mengupdate data hari libur (update)
    public function update(Request $request, $id)
    {
        $libur = Libur::findOrFail($id);

        // Validasi input
        $request->validate([
            'tanggal' => 'required|date|unique:liburs,tanggal,' . $id, // Pastikan tanggal unik, kecuali yang sedang di-update
            'keterangan' => 'required|string|max:255',
        ]);

        // Perbarui data hari libur
        $libur->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('libur.index')->with('success', 'Hari libur berhasil diperbarui.');
    }

    // Method untuk menghapus hari libur (destroy)
    public function destroy($id)
    {
        $libur = Libur::findOrFail($id);
        $libur->delete();

        return redirect()->route('libur.index')->with('success', 'Hari libur berhasil dihapus.');
    }
    public function edit($id)
    {
        // Cari hari libur berdasarkan ID
        $libur = Libur::findOrFail($id);

        // Kembalikan data hari libur dalam bentuk JSON untuk digunakan di AJAX
        return response()->json($libur);
    }
    // Method untuk mengambil data hari libur dari API
    public function fetchLiburFromApi()
    {
        try {
            // Panggil API untuk mendapatkan data hari libur tahun ini
            $response = Http::get('https://dayoffapi.vercel.app/api');
            $data = $response->json();

            // Simpan data hari libur ke dalam database
            foreach ($data as $holiday) {
                Libur::updateOrCreate(
                    ['tanggal' => $holiday['tanggal']], // Cek berdasarkan tanggal
                    [
                        'keterangan' => $holiday['keterangan'], // Isi keterangan dari API

                    ]
                );
            }

            return redirect()->route('libur.index')->with('success', 'Hari libur berhasil diperbarui dari API.');
        } catch (\Exception $e) {
            return redirect()->route('libur.index')->with('error', 'Gagal mengambil data hari libur: ' . $e->getMessage());
        }
    }
    public function indexKaryawan()
    {
        // Ambil semua data hari libur
        $hariLibur = Libur::orderBy('tanggal', 'asc')->get(); // Mengurutkan berdasarkan tanggal

        // Kembalikan view dengan data hari libur
        return view('libur.indexKaryawan', compact('hariLibur'));
    }
}
