<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAbsensi extends Model
{
    protected $table = 'data_absensi';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'id_kary', 'tgl_masuk', 'jam_in', 'jam_out', 'kehadiran', 'keterangan', 'fhoto',
        'dt', 'unit', 'lokasi', 'divisi', 'shift', 'catatan', 'waktu'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada relasi dengan tabel karyawan atau tabel lain
    // Misalnya relasi ke tabel karyawan
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'id_kary');
    }
}
