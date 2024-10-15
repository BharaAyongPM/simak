<?php

namespace App\Http\Controllers;

use App\Models\Peraturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PeraturanController extends Controller
{
    // Menampilkan daftar peraturan
    public function index()
    {
        $peraturans = Peraturan::with('user')->get(); // Ambil data peraturan dengan relasi user (karyawan)
        return view('peraturan.index', compact('peraturans'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'fhoto' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:5000', // Bisa berupa gambar atau dokumen
            'status' => 'required|in:aktif,nonaktif',
            'jenis' => 'required|string|max:255',

        ]);

        // Map status to 1 (aktif) or 0 (nonaktif)
        $status = $request->status === 'aktif' ? 1 : 0;

        // Simpan file jika ada
        $path = null;
        if ($request->hasFile('fhoto')) {
            // Buat nama file unik berdasarkan waktu saat ini dan ekstensi file
            $fhotoName = time() . '.' . $request->fhoto->extension();

            // Pindahkan file ke direktori public/storage/peraturan_files
            $request->fhoto->move(public_path('storage/peraturan_files'), $fhotoName);

            // Simpan path yang akan disimpan ke database (sesuai dengan URL yang benar)
            $path = 'peraturan_files/' . $fhotoName;
        }
        // Simpan data peraturan
        Peraturan::create([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'fhoto' => $path,
            'status' => $status, // Set status to 1 or 0 based on the selection
            'jenis' => $request->jenis,
            'karyawan' => Auth::id(), // Set the karyawan field to the logged-in user
            'display_info' => null,
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

        ]);

        // Map status to 1 (aktif) or 0 (nonaktif)
        $status = $request->status === 'aktif' ? 1 : 0;

        // Periksa apakah ada file baru yang di-upload
        // Periksa apakah ada file baru yang di-upload
        if ($request->hasFile('fhoto')) {
            // Hapus file lama jika ada
            if ($peraturan->fhoto) {
                $oldFilePath = public_path('storage/' . $peraturan->fhoto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Buat nama file unik berdasarkan waktu saat ini dan ekstensi file
            $fhotoName = time() . '.' . $request->fhoto->extension();

            // Pindahkan file ke direktori public/storage/peraturan_files
            $request->fhoto->move(public_path('storage/peraturan_files'), $fhotoName);

            // Simpan path yang akan disimpan ke database (sesuai dengan URL yang benar)
            $path = 'peraturan_files/' . $fhotoName;
        } else {
            $path = $peraturan->fhoto; // Tetap gunakan file lama jika tidak ada perubahan
        }

        // Update data peraturan
        $peraturan->update([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'fhoto' => $path,
            'status' => $status, // Set status to 1 or 0 based on the selection
            'jenis' => $request->jenis,
            'karyawan' => Auth::id(), // Set the karyawan field to the logged-in user
            'display_info' => null,
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
