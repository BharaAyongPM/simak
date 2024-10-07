<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        $user = auth()->user(); // Mendapatkan user yang sedang login

        // Validasi input
        $attributes = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'name' => 'required|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // Validasi foto
        ]);

        // Jika ada file foto yang diunggah, simpan file dan update 'foto' di database
        if ($request->hasFile('foto')) {
            // Menghapus foto lama jika ada
            if ($user->foto) {
                Storage::delete($user->foto);
            }

            // Menyimpan foto baru
            $attributes['foto'] = $request->file('foto')->store('profile_photos');
        }

        // Update data user
        $user->update($attributes);

        return back()->withStatus('Profile successfully updated.');
    }
}
