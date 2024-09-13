<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCuti extends Model
{
    use HasFactory;
    protected $table = 'jenis_cuti';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['nama', 'jumlah'];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel lain
}
