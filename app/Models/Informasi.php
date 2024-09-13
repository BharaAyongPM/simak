<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;
    protected $table = 'informasi';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'tanggal', 'informasi', 'fhoto', 'status_informasi', 'divisi',
        'jenis', 'unit', 'nama_pengirim', 'display_info', 'unit_banyak'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada relasi dengan tabel divisi atau unit atau tabel lain
}
