<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\Redeem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LemburController extends Controller
{
    // Menampilkan daftar lembur
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua lembur dan histori redeem
        $lembur = Lembur::where('user_id', $userId)->get();
        $redeemHistory = Redeem::where('user_id', $userId)->get();

        $totalDeposit = $lembur->where('jenis_lembur', 'deposit')->sum('deposit_jam');

        return view('lembur.index', compact('lembur', 'redeemHistory', 'totalDeposit'));
    }

    // Mengajukan lembur
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal_lembur' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'jenis_lembur' => 'required|in:bayar,deposit',
            'keterangan' => 'nullable|string',
            'dokumen' => 'nullable|file|mimes:jpg,png,pdf',
        ]);

        // Hitung durasi lembur dalam jam
        $jamMulai = Carbon::parse($request->jam_mulai);
        $jamSelesai = Carbon::parse($request->jam_selesai);
        $durasiLembur = $jamSelesai->diffInHours($jamMulai);

        // Jika dokumen di-upload, simpan
        $dokumenPath = null;
        if ($request->hasFile('dokumen')) {
            $dokumenPath = $request->file('dokumen')->store('lembur_dokumen', 'public');
        }

        // Buat data lembur baru
        $lembur = new Lembur([
            'user_id' => Auth::id(),
            'tanggal_pengajuan' => now(),
            'tanggal_lembur' => $request->tanggal_lembur,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keterangan' => $request->keterangan,
            'dokumen' => $dokumenPath,
            'jenis_lembur' => $request->jenis_lembur,
            'total_jam' => $durasiLembur,
            'approve_1' => false,
            'approve_2' => false,
        ]);

        // Jika lembur deposit, akumulasi jam lembur di deposit_jam
        if ($request->jenis_lembur == 'deposit') {
            $lembur->deposit_jam = $durasiLembur;
        } else {
            // Jika lembur bayar, hitung total bayar (misalnya gaji lembur per jam = 50000)
            $lembur->rupiah_per_jam = 0;  // Bisa dinamis, misalnya ambil dari user
            $lembur->total_bayar = $lembur->rupiah_per_jam * $durasiLembur;
        }

        $lembur->save();

        return redirect()->route('lembur.index')->with('success', 'Pengajuan lembur berhasil.');
    }

    // Redeem lembur deposit jika total jam mencapai 7 jam
    public function redeem(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'hari_libur' => 'required|date',
        ]);

        $userId = Auth::id();
        $totalJamYangDibutuhkan = 7; // Jam yang dibutuhkan untuk redeem

        // Ambil semua lembur deposit berdasarkan user dan jenis lembur deposit, urutkan dari yang terlama
        $lemburDeposits = Lembur::where('user_id', $userId)
            ->where('jenis_lembur', 'deposit')
            ->where('redeemed', false) // Lembur yang belum di-redeem
            ->orderBy('tanggal_lembur', 'asc') // Ambil dari yang terlama
            ->get();

        $totalDepositTersedia = $lemburDeposits->sum('deposit_jam'); // Total jam deposit yang ada

        // Jika deposit tidak cukup untuk redeem
        if ($totalDepositTersedia < $totalJamYangDibutuhkan) {
            return back()->withErrors(['error' => 'Deposit tidak mencukupi untuk redeem.']);
        }

        // Jalankan proses redeem
        $jamTerpakai = 0;
        foreach ($lemburDeposits as $deposit) {
            $jamYangTersisa = $deposit->deposit_jam; // Jam lembur yang tersisa di setiap deposit

            if ($jamTerpakai + $jamYangTersisa >= $totalJamYangDibutuhkan) {
                $jamYangDikurangi = $totalJamYangDibutuhkan - $jamTerpakai;
                $deposit->deposit_jam -= $jamYangDikurangi; // Kurangi deposit yang terlama
                $jamTerpakai += $jamYangDikurangi;

                // Tandai sebagai selesai jika total jam lembur habis
                if ($deposit->deposit_jam == 0) {
                    $deposit->redeemed = true;
                }
                $deposit->save();
                break;
            } else {
                $jamTerpakai += $jamYangTersisa;
                $deposit->deposit_jam = 0; // Kosongkan lembur yang diambil penuh
                $deposit->redeemed = true; // Tandai sebagai selesai di-redeem
                $deposit->save();
            }
        }

        // Buat record redeem baru di tabel redeem
        $redeem = Redeem::create([
            'user_id' => $userId,
            'hari_libur' => $request->hari_libur,
            'jam_yang_diredeem' => $totalJamYangDibutuhkan,
            'approve_1' => 0, // Default belum di-approve
            'approve_2' => 0, // Default belum di-approve
        ]);

        return redirect()->route('lembur.index')->with('success', 'Redeem lembur berhasil diajukan. Menunggu approval.');
    }

    // Menghapus lembur
    public function destroy($id)
    {
        $lembur = Lembur::findOrFail($id);

        // Hanya bisa menghapus jika approve_1 masih false
        if ($lembur->approve_1) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus lembur yang sudah disetujui.']);
        }

        $lembur->delete();

        return redirect()->route('lembur.index')->with('success', 'Lembur berhasil dihapus.');
    }
}
