<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan detail profil
    public function profil()
    {
        // Mengambil user yang sedang login dan memuat relasi 'divisi'
        $user = User::with('bag', 'lv', 'unt')->find(auth()->id());

        // Debugging untuk memeriksa apakah relasi 'divisi' sudah dimuat


        return view('pages.profile', compact('user'));
    }

    // Mengupdate profil termasuk nama, email, dan foto
    public function update(Request $request)
    {
        // Validasi input yang bisa di-update
        $request->validate([
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'no_telp' => 'required|string|max:20',
            'agama' => 'required|string|max:50',
            'kelamin' => 'required|in:Pria,Wanita',
            'alamat' => 'required|string|max:255',
        ]);

        // Update data user yang sedang login
        $user = auth()->user();
        $user->Update([
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'agama' => $request->agama,
            'kelamin' => $request->kelamin,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
    public function updateFotoProfil(Request $request)
    {
        // Validasi input gambar
        $request->validate([
            'croppedImageData' => 'required|string', // base64 data dari gambar yang di-crop
        ]);

        // Mengambil user yang sedang login
        $user = auth()->user();

        // Decode base64 image
        $image = $request->input('croppedImageData');
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'foto_' . time() . '.png';

        // Simpan gambar ke dalam direktori storage/foto
        Storage::disk('public')->put('foto/' . $imageName, base64_decode($image));

        // Update foto profil user
        $user->update([
            'foto' => $imageName,
        ]);

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
    }
}
