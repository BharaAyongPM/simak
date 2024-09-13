<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = 'gaji';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'karyawan_id', 'bulan', 'tahun', 'gaji_pokok', 'tunjangan', 'potongan', 'total'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = false;  // Tidak menggunakan timestamps
}
