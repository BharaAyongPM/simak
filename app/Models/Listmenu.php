<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listmenu extends Model
{
    use HasFactory;
    protected $table = 'listmenu';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['urut', 'menu', 'submenu1', 'alamat'];  // Kolom yang dapat diisi secara massal
    public $timestamps = false;  // Tidak menggunakan timestamps

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel lain
}
