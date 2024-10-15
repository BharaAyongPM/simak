<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\Informasi;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    // Menampilkan daftar informasi
    public function index()
    {
        $informasis = Informasi::with(['bag', 'unt'])->get(); // Ambil data informasi dengan relasi ke bag dan unit
        $bags = Bag::all(); // Ambil semua data bagian
        $units = Unit::all(); // Ambil semua data unit
        return view('informasi.index', compact('informasis', 'bags', 'units'));
    }

    // Menyimpan informasi baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'informasi' => 'required|string',
            'foto' => 'nullable|file|mimes:jpg,png|max:2048',
            'status_informasi' => 'required|in:0,1',
            'jenis' => 'required|in:semua,bagian',
            'bagian' => 'nullable|exists:bag,id_bagian',
            'unit' => 'nullable|exists:unit,id',
            'display_info' => 'required|in:diam,bergerak',
        ]);

        // Simpan file jika ada
        $path = null;
        if ($request->hasFile('foto')) {
            // Buat nama file unik berdasarkan waktu saat ini dan ekstensi file
            $fotoName = time() . '.' . $request->foto->extension();

            // Pindahkan file ke direktori public/storage/informasi_files
            $request->foto->move(public_path('storage/informasi_files'), $fotoName);

            // Simpan path yang akan disimpan ke database (sesuai dengan URL yang benar)
            $path = 'informasi_files/' . $fotoName;
        }
        // Simpan informasi baru dengan ID user yang sedang login
        Informasi::create([
            'tanggal' => $request->tanggal,
            'informasi' => $request->informasi,
            'foto' => $path,
            'status_informasi' => $request->status_informasi,
            'jenis' => $request->jenis,
            'bagian' => $request->jenis == 'semua' ? null : $request->bagian,
            'unit' => $request->jenis == 'semua' || !$request->bagian ? null : $request->unit,
            'user_id' => Auth::id(), // Pastikan user_id diambil dari ID user yang login
            'display_info' => $request->display_info,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil ditambahkan.');
    }

    // Mengupdate data informasi
    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'informasi' => 'required|string',
            'foto' => 'nullable|file|mimes:jpg,png|max:2048',
            'status_informasi' => 'required|in:0,1',
            'jenis' => 'required|in:semua,bagian',
            'bagian' => 'nullable|exists:bag,id_bagian',
            'unit' => 'nullable|exists:unit,id',
            'display_info' => 'required|in:diam,bergerak',
        ]);

        // Periksa apakah ada file baru yang di-upload
        if ($request->hasFile('foto')) {
            // Hapus file lama jika ada
            if ($informasi->foto) {
                Storage::delete($informasi->foto);
            }

            // Simpan file baru
            $path = $request->file('foto')->store('informasi_files', 'public');
        } else {
            $path = $informasi->foto; // Tetap gunakan file lama jika tidak ada perubahan
        }

        // Update data informasi
        $informasi->update([
            'tanggal' => $request->tanggal,
            'informasi' => $request->informasi,
            'foto' => $path,
            'status_informasi' => $request->status_informasi,
            'jenis' => $request->jenis,
            'bagian' => $request->jenis == 'semua' ? null : $request->bagian,
            'unit' => $request->jenis == 'semua' || !$request->bagian ? null : $request->unit,
            'user' => Auth::id(), // Menggunakan ID user yang sedang login
            'display_info' => $request->display_info,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil diperbarui.');
    }


    // Menghapus data informasi
    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);

        // Hapus file yang terkait jika ada
        if ($informasi->foto) {
            Storage::delete($informasi->foto);
        }

        // Hapus data informasi
        $informasi->delete();

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil dihapus.');
    }
    public function edit($id)
    {
        // Ambil data informasi berdasarkan ID
        $informasi = Informasi::findOrFail($id);

        // Kembalikan data informasi dalam format JSON untuk digunakan di frontend (AJAX)
        return response()->json($informasi);
    }
    public function indexKaryawan()
    {
        // Ambil semua informasi yang aktif
        $informasi = Informasi::with('user', 'bag', 'unt')
            ->where('status_informasi', 1)  // Hanya informasi aktif
            ->orderBy('tanggal', 'desc')
            ->get();

        // Kembalikan view dengan data informasi
        return view('informasi.indexKaryawan', compact('informasi'));
    }
}
