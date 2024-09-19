<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'tanggal',
        'lat',
        'lng',
        'karyawan',
        'jenis',
        'jam',
        'lokasi',
        'jam_pulang',
        'foto',
        'ip_address',
        'dt',
        'keterangan',
        'shift',
        'catatan',
        'waktu_dt',
        'tgl_pulang'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi dengan tabel user untuk karyawan yang melakukan absensi
    public function karyn()
    {
        return $this->belongsTo(User::class, 'karyawan', 'id');  // 'karyawan' adalah FK di tabel absensi yang mengacu pada 'id' di tabel user
    }

    // Tambahkan lebih banyak fungsi relasi jika diperlukan untuk pengelolaan absensi
}
