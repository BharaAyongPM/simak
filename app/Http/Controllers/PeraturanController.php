<?php

namespace App\Http\Controllers;

use App\Models\Peraturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeraturanController extends Controller
{
    // Menampilkan daftar peraturan
    public function index()
    {
        $peraturans = Peraturan::with('user')->get(); // Ambil data peraturan dengan relasi user (karyawan)
        return view('peraturan.index', compact('peraturans'));
    }

    // Menyimpan peraturan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'fhoto' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048', // Bisa berupa gambar atau dokumen
            'status' => 'required|in:aktif,nonaktif',
            'jenis' => 'required|string|max:255',
            'karyawan' => 'required|exists:users,id',
            'display_info' => 'nullable|string',
        ]);

        // Simpan file jika ada
        $path = null;
        if ($request->hasFile('fhoto')) {
            $path = $request->file('fhoto')->store('peraturan_files');
        }

        // Simpan data peraturan
        Peraturan::create([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'fhoto' => $path,
            'status' => $request->status,
            'jenis' => $request->jenis,
            'karyawan' => $request->karyawan,
            'display_info' => $request->display_info,
        ]);

        return redirect()->route('peraturan.index')->with('success', 'Peraturan berhasil ditambahkan.');
    }

    // Mengupdate data peraturan
    public function update(Request $request, $id)
    {
        $peraturan = Peraturan::findOrFail($id);

        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'fhoto' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
            'status' => 'required|in:aktif,nonaktif',
            'jenis' => 'required|string|max:255',
            'karyawan' => 'required|exists:users,id',
            'display_info' => 'nullable|string',
        ]);

        // Periksa apakah ada file baru yang di-upload
        if ($request->hasFile('fhoto')) {
            // Hapus file lama jika ada
            if ($peraturan->fhoto) {
                Storage::delete($peraturan->fhoto);
            }

            // Simpan file baru
            $path = $request->file('fhoto')->store('peraturan_files');
        } else {
            $path = $peraturan->fhoto;
        }

        // Update data peraturan
        $peraturan->update([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'fhoto' => $path,
            'status' => $request->status,
            'jenis' => $request->jenis,
            'karyawan' => $request->karyawan,
            'display_info' => $request->display_info,
        ]);

        return redirect()->route('peraturan.index')->with('success', 'Peraturan berhasil diperbarui.');
    }

    // Menghapus data peraturan
    public function destroy($id)
    {
        $peraturan = Peraturan::findOrFail($id);

        // Hapus file yang terkait jika ada
        if ($peraturan->fhoto) {
            Storage::delete($peraturan->fhoto);
        }

        // Hapus data peraturan
        $peraturan->delete();

        return redirect()->route('peraturan.index')->with('success', 'Peraturan berhasil dihapus.');
    }
    public function edit($id)
    {
        // Ambil data peraturan berdasarkan ID
        $peraturan = Peraturan::findOrFail($id);

        // Kembalikan data peraturan dalam format JSON untuk digunakan di frontend (AJAX)
        return response()->json($peraturan);
    }
    public function viewperaturan()
    {
        $peraturans = Peraturan::with('user')->get(); // Ambil data peraturan dengan relasi user (karyawan)
        return view('peraturan.view', compact('peraturans'));
    }
}
