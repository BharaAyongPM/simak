<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teguran extends Model
{
    use HasFactory;
    protected $table = 'teguran';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'tgl_surat', 'karyawan', 'alpa', 'dt', 'awal', 'akhir', 'baca', 'isi'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi dengan tabel user untuk karyawan yang menerima teguran
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan');  // 'karyawan' adalah FK di tabel teguran yang mengacu pada 'id' di tabel user
    }
}
