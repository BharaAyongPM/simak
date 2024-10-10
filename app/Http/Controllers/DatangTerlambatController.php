<?php



namespace App\Http\Controllers;

use App\Models\DatangTerlambat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatangTerlambatController extends Controller
{
    // 1. Index method (Menampilkan semua data datang terlambat untuk user yang login)
    public function index()
    {
        $datangTerlambat = DatangTerlambat::where('karyawan', Auth::id())->get(); // Mendapatkan data datang terlambat dari user yang sedang login
        return view('datang_terlambat.index', compact('datangTerlambat')); // Menampilkan view dengan data datang terlambat
    }

    // Menyimpan data datang terlambat baru dari modal form
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        // Buat data datang terlambat baru
        DatangTerlambat::create([
            'karyawan' => Auth::id(), // Mengambil ID pengguna yang sedang login
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'app_1' => 0, // Set default sebagai pending
            'app_2' => 0, // Set default sebagai pending
            'approve_atasan' => null, // Default kosong
            'approve_sdi' => null, // Default kosong
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('datang_terlambat.index')->with('success', 'Pengajuan datang terlambat berhasil diajukan.');
    }

    // Edit Datang Terlambat
    public function edit($id)
    {
        $datangTerlambat = DatangTerlambat::findOrFail($id); // Mendapatkan data datang terlambat berdasarkan ID
        return response()->json($datangTerlambat); // Mengirimkan data sebagai JSON untuk ditampilkan di modal
    }

    // Update Datang Terlambat
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $datangTerlambat = DatangTerlambat::findOrFail($id);

        // Update data datang terlambat
        $datangTerlambat->update($validatedData);

        return redirect()->back()->with('success', 'Pengajuan datang terlambat berhasil diupdate.');
    }

    // Hapus Datang Terlambat
    public function destroy($id)
    {
        $datangTerlambat = DatangTerlambat::findOrFail($id);
        $datangTerlambat->delete();

        return redirect()->back()->with('success', 'Pengajuan datang terlambat berhasil dihapus.');
    }

    // Menampilkan data datang terlambat karyawan untuk atasan
    public function dataDatangTerlambat()
    {
        // Mendapatkan user yang sedang login (Atasan)
        $user = auth()->user();

        // Mengambil data datang terlambat dari karyawan yang berada di unit yang sama dengan atasan
        // Daftar pengajuan datang terlambat yang belum di-approve (pending)
        $datangTerlambatPending = DatangTerlambat::with('user')
            ->whereHas('user', function ($query) use ($user) {
                $query->where('unit', $user->unit); // Ambil karyawan yang unit-nya sama dengan atasan
            })
            ->where('app_1', 0) // Hanya yang belum diapprove oleh atasan
            ->get();

        // Daftar pengajuan yang sudah di-approve (approved) atau ditolak (rejected) (histori)
        $datangTerlambatApprovedOrRejected = DatangTerlambat::with(['user', 'approvedBy1'])
            ->whereHas('user', function ($query) use ($user) {
                $query->where('unit', $user->unit); // Ambil karyawan yang unit-nya sama dengan atasan
            })
            ->whereIn('app_1', [1, -1]) // Yang sudah diapprove atau ditolak oleh atasan
            ->get();

        return view('datang_terlambat.datangkaryawan', compact('datangTerlambatPending', 'datangTerlambatApprovedOrRejected'));
    }
}
