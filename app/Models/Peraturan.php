<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peraturan extends Model
{
    use HasFactory;
    protected $table = 'peraturan';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'tanggal',
        'judul',
        'keterangan',
        'fhoto',
        'status',
        'jenis',
        'karyawan',
        'display_info'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel karyawan atau tabel lain
    public function user()
    {
        return $this->belongsTo(User::class, 'karyawan'); // 'karyawan' adalah foreign key yang merujuk ke ID user
    }
}
