<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiTambahan extends Model
{
    protected $table = 'absensi_tambahan';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'tanggal', 'lat', 'lng', 'karyawan', 'jenis', 'jam', 'lokasi',
        'jam_pulang', 'fhoto', 'ip_address', 'dt', 'keterangan', 'shift',
        'catatan', 'waktu_dt'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi dengan tabel user untuk karyawan yang melakukan absensi tambahan
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan');  // 'karyawan' adalah FK di tabel absensi_tambahan yang mengacu pada 'id' di tabel user
    }
}
