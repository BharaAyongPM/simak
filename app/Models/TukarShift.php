<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TukarShift extends Model
{
    use HasFactory;
    protected $table = 'tukar_shift';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'tanggal', 'tgl_kerja', 'karyawan_asal', 'shift_asal', 'karyawan_ganti', 'shift_ganti',
        'tgl_ganti', 'tgl_approve', 'approve', 'keterangan', 'approve_1', 'approve_atasan'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi dengan tabel user untuk karyawan yang terlibat dalam tukar shift
    public function karyawanAsal()
    {
        return $this->belongsTo(User::class, 'karyawan_asal');
    }

    public function karyawanGanti()
    {
        return $this->belongsTo(User::class, 'karyawan_ganti');
    }

    public function approveAtasan()
    {
        return $this->belongsTo(User::class, 'approve_atasan');
    }
}
