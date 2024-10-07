<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\JenisCuti;
use App\Models\StokCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    // Tampilkan daftar cuti
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Cek apakah tanggal masuk ada dan hitung selisih dengan hari ini
        $tanggalMasuk = $user->tanggal_masuk;
        $satuTahunKerja = \Carbon\Carbon::parse($tanggalMasuk)->addYear(1);
        $hariIni = \Carbon\Carbon::now();

        // Jika belum mencapai satu tahun
        if ($hariIni->lessThan($satuTahunKerja)) {
            // Redirect ke halaman absensi dengan pesan error
            return redirect('/absensi')->with('error', 'Anda belum satu tahun bekerja dan belum bisa mengakses form cuti.');
        }

        // Ambil data cuti yang diajukan oleh user yang sedang login
        $cuti = Cuti::with('jenisCuti', 'user')->where('user_id', Auth::id())->get();

        // Ambil data jenis cuti untuk modal
        $jenisCuti = JenisCuti::all();

        // Ambil stok cuti user yang sedang login
        $stokCuti = StokCuti::where('user_id', Auth::id())->get();

        return view('cuti.index', compact('cuti', 'jenisCuti', 'stokCuti'));
    }

    // Simpan data cuti baru
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_cuti_id' => 'required|exists:jenis_cuti,id',
            'keterangan' => 'required|string',
        ]);

        // Hitung jumlah hari cuti yang diajukan
        $tanggalMulai = \Carbon\Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = \Carbon\Carbon::parse($request->tanggal_selesai);
        $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Ambil jenis cuti dari tabel jenis_cuti
        $jenisCuti = JenisCuti::find($request->jenis_cuti_id);

        // Cek stok cuti untuk user dan jenis cuti yang dipilih
        $stokCuti = StokCuti::where('user_id', Auth::id())
            ->where('jenis_cuti', $request->jenis_cuti_id)
            ->first();

        // Jika stok cuti belum ada, buat entri baru di stok cuti
        if (!$stokCuti) {
            $stokCuti = StokCuti::create([
                'user_id' => Auth::id(),
                'awal_cuti' => now()->startOfYear()->format('Y-m-d'),  // Awal tahun
                'akhir_cuti' => now()->endOfYear()->format('Y-m-d'),   // Akhir tahun
                'jumlah' => $jenisCuti->jumlah,       // Jumlah dari jenis cuti
                'pakai' => 0,
                'sisa' => $jenisCuti->jumlah,
                'jenis_cuti' => $request->jenis_cuti_id,
            ]);
        }

        // Pastikan sisa cuti mencukupi
        if ($stokCuti->sisa < $jumlahHari) {
            return back()->withErrors(['error' => 'Sisa cuti tidak mencukupi.']);
        }

        // Kurangi sisa cuti dan tambahkan jumlah hari yang dipakai
        $stokCuti->sisa -= $jumlahHari;
        $stokCuti->pakai += $jumlahHari;
        $stokCuti->save(); // Simpan perubahan ke database

        // Simpan data pengajuan cuti
        Cuti::create([
            'user_id' => Auth::id(),
            'tanggal_pengajuan' => now()->format('Y-m-d'),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_cuti_id' => $request->jenis_cuti_id,
            'sisa_cuti' => $stokCuti->sisa,
            'keterangan' => $request->keterangan,
            'approve_1' => 0, // Awalnya belum di-approve
            'approve_2' => 0,
        ]);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil.');
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::find($id);

        // Cek apakah approve_1 sudah disetujui (jika iya, tidak bisa diedit)
        if ($cuti->approve_1 == 1) {
            return back()->withErrors(['error' => 'Pengajuan cuti sudah disetujui, tidak bisa diubah.']);
        }

        // Validasi input
        $validatedData = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string',
        ]);

        // Hitung jumlah hari cuti yang baru
        $tanggalMulaiBaru = \Carbon\Carbon::parse($request->tanggal_mulai);
        $tanggalSelesaiBaru = \Carbon\Carbon::parse($request->tanggal_selesai);
        $jumlahHariBaru = $tanggalMulaiBaru->diffInDays($tanggalSelesaiBaru) + 1;

        // Ambil stok cuti berdasarkan user dan jenis cuti
        $stokCuti = StokCuti::where('user_id', $cuti->user_id)
            ->where('jenis_cuti', $cuti->jenis_cuti_id)
            ->first();

        if (!$stokCuti) {
            return back()->withErrors(['error' => 'Stok cuti tidak ditemukan.']);
        }

        // Hitung jumlah hari cuti lama
        $tanggalMulaiLama = \Carbon\Carbon::parse($cuti->tanggal_mulai);
        $tanggalSelesaiLama = \Carbon\Carbon::parse($cuti->tanggal_selesai);
        $jumlahHariLama = $tanggalMulaiLama->diffInDays($tanggalSelesaiLama) + 1;

        // Kembalikan stok cuti lama sebelum melakukan update
        $stokCuti->increment('sisa', $jumlahHariLama);
        $stokCuti->decrement('pakai', $jumlahHariLama);

        // Pastikan stok mencukupi untuk pengajuan yang baru
        if ($stokCuti->sisa < $jumlahHariBaru) {
            return back()->withErrors(['error' => 'Sisa cuti tidak mencukupi untuk perubahan.']);
        }

        // Kurangi stok sesuai dengan jumlah hari cuti yang baru
        $stokCuti->decrement('sisa', $jumlahHariBaru);
        $stokCuti->increment('pakai', $jumlahHariBaru);

        // Perbarui data cuti
        $cuti->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'sisa_cuti' => $stokCuti->sisa, // Update sisa_cuti agar sinkron dengan stok cuti
        ]);

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diupdate.');
    }

    public function destroy($id)
    {
        $cuti = Cuti::find($id);

        // Cek apakah approve_1 sudah 1 (jika iya, tidak bisa dihapus)
        if ($cuti->approve_1 == 1) {
            return back()->withErrors(['error' => 'Pengajuan cuti sudah disetujui, tidak bisa dihapus.']);
        }

        // Ambil stok cuti berdasarkan jenis cuti
        $stokCuti = StokCuti::where('user_id', $cuti->user_id)
            ->where('jenis_cuti', $cuti->jenis_cuti_id)
            ->first();

        if (!$stokCuti) {
            return back()->withErrors(['error' => 'Stok cuti tidak ditemukan.']);
        }

        // Hitung jumlah hari cuti yang diajukan
        $jumlahHari = \Carbon\Carbon::parse($cuti->tanggal_mulai)->diffInDays($cuti->tanggal_selesai) + 1;

        // Kembalikan sisa cuti dan kurangi jumlah pakai
        $stokCuti->increment('sisa', $jumlahHari);
        $stokCuti->decrement('pakai', $jumlahHari);

        // Hapus pengajuan cuti
        $cuti->delete();

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dihapus.');
    }
    // Ambil data cuti untuk modal edit
    public function edit(Cuti $cuti)
    {
        return response()->json($cuti);
    }
}
