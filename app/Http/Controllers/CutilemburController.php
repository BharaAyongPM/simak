<?php

namespace App\Http\Controllers;

use App\Models\Cutilembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutilemburController extends Controller
{
    public function index()
    {
        // Mengambil data izin/cuti/lembur/sakit
        $cutilembur = Cutilembur::with('karyn', 'bag')->where('karyawan', Auth::id())->get();

        return view('cutilembur.index', compact('cutilembur'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis' => 'required|string',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'keterangan' => 'nullable|string',
            'dokumen' => 'nullable|image|max:2048',
        ]);

        // Simpan dokumen jika ada
        $filename = null;
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/dokumen'), $filename);
        }

        // Menyimpan data ke tabel cutilembur
        Cutilembur::create([
            'tanggal' => now(),
            'karyawan' => Auth::id(),
            'tgl_cl' => $request->tanggal_awal,
            'jam_mulai' => $request->tanggal_awal,
            'jam_akhir' => $request->tanggal_akhir,
            'keterangan' => $request->keterangan,
            'fhoto' => $filename,
            'jenis' => $request->jenis,
            'divisi' => Auth::user()->divisi,
        ]);

        return redirect()->route('cutilembur.index')->with('success', 'Data berhasil disimpan!');
    }
    public function edit($id)
    {
        $izin = Cutilembur::findOrFail($id);
        return response()->json($izin);
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'jenis' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'keterangan' => 'required',
        ]);

        // Cari data cutilembur berdasarkan id
        $izin = Cutilembur::findOrFail($id);

        // Update data
        $izin->update($validatedData);

        // Upload dokumen jika ada
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = 'dokumen_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/dokumen'), $filename);
            $izin->fhoto = $filename;
            $izin->save();
        }

        return redirect()->route('cutilembur.index')->with('success', 'Data izin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $izin = Cutilembur::findOrFail($id);
        $izin->delete();
        return redirect()->route('cutilembur.index')->with('success', 'Data izin berhasil dihapus.');
    }
}
