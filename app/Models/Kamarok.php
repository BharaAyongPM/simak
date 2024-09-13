<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamarok extends Model
{
    use HasFactory;
    protected $table = 'kamarok$';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['kd_kamar', 'kd_bangsal', 'kamar', 'kelas', 'tarif'];  // Kolom yang dapat diisi secara massal
    public $timestamps = false;  // Tidak menggunakan timestamps

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel lain
}
