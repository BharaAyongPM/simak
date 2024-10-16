<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    // 1. Index method (Menampilkan semua data izin)
    public function index()
    {
        $izin = Izin::where('user_id', Auth::id())->get(); // Mendapatkan data izin dari user yang sedang login
        return view('izin.index', compact('izin')); // Menampilkan view dengan data izin
    }

    // Menyimpan data izin baru dari modal form
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'jenis' => 'required|in:Sakit,Izin',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string|max:255',
            'dokumen' => 'nullable|file|mimes:jpg,png,pdf|max:2048', // Sesuaikan dengan file upload yang diizinkan
        ]);

        // Upload dokumen jika ada
        $dokumenName = null;
        if ($request->hasFile('dokumen')) {
            $dokumenName = time() . '.' . $request->dokumen->extension();
            $request->dokumen->move(public_path('uploads/izin'), $dokumenName);
        }

        // Buat data izin baru dengan pengisian otomatis tanggal pengajuan
        Izin::create([
            'jenis' => $request->jenis,
            'user_id' => Auth::id(), // Mengambil ID pengguna yang sedang login
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'dokumen' => $dokumenName,
            'approve_1' => 0, // Set default sebagai pending
            'approve_2' => 0, // Set default sebagai pending
            'tanggal_pengajuan' => now(), // Mengisi otomatis tanggal pengajuan dengan tanggal hari ini
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('izin.index')->with('success', 'Izin berhasil diajukan.');
    }
    // Edit Izin
    public function edit($id)
    {
        $izin = Izin::findOrFail($id); // Mendapatkan data izin berdasarkan ID
        return response()->json($izin); // Mengirimkan data izin sebagai JSON untuk ditampilkan di modal
    }

    // Update Izin
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jenis' => 'required|in:Sakit,Izin',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'dokumen' => 'nullable|file|mimes:jpg,png,pdf',
        ]);

        $izin = Izin::findOrFail($id);

        // Upload dokumen jika ada
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/izin'), $filename);
            $izin->dokumen = $filename;
        }

        // Update data izin
        $izin->update($validatedData);

        return redirect()->back()->with('success', 'Pengajuan Izin berhasil diupdate.');
    }

    // Hapus Izin
    public function destroy($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->delete();

        return redirect()->back()->with('success', 'Pengajuan Izin berhasil dihapus.');
    }
    public function dataizin()
    {
        $user = Auth::user();

        // Jika user adalah Kepala Unit, tampilkan izin dari karyawan di unit yang sama
        if ($user->hasRole('KEPALA UNIT')) {
            $izinPending = Izin::with('user')
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('unit', $user->unit) // Karyawan di unit yang sama
                        ->whereHas('roles', function ($q) {
                            $q->where('name', 'KARYAWAN'); // Hanya yang rolenya Karyawan
                        });
                })
                ->where('approve_1', 0) // Belum di-approve
                ->get();
        }
        // Jika user adalah Kepala Bagian, tampilkan izin dari Kepala Unit (berdasarkan bagian)
        elseif ($user->hasRole('KEPALA BAGIAN')) {
            $izinPending = Izin::with('user')
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('divisi', $user->divisi) // Karyawan di bagian yang sama
                        ->whereHas('roles', function ($q) {
                            $q->where('name', 'KEPALA UNIT'); // Hanya yang rolenya Kepala Unit
                        });
                })
                ->where('approve_1', 0) // Belum di-approve
                ->get();
        }
        // Jika user adalah Direktur, tampilkan izin dari Kepala Bagian (tanpa unit, berdasarkan divisi)
        elseif ($user->hasRole('DIREKTUR')) {
            $izinPending = Izin::with('user')
                ->whereHas('user', function ($query) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', 'KEPALA BAGIAN'); // Hanya yang rolenya Kepala Bagian
                    });
                })
                ->where('approve_1', 0) // Belum di-approve
                ->get();
        } else {
            $izinPending = collect(); // Jika tidak ada role yang sesuai, kosongkan izin
        }

        // Ambil data history izin (yang sudah di-approve atau ditolak)
        $izinApprovedOrRejected = Izin::with(['user', 'approvedBy1'])
            ->where('approve_1', '!=', 0) // History yang sudah di-approve atau ditolak
            ->get();

        return view('izin.izinkaryawan', compact('izinPending', 'izinApprovedOrRejected'));
    }
}
