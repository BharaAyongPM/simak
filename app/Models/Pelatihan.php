<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;
    protected $table = 'pelatihan';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'narsum', 'lampiran', 'karyawan', 'materi', 'jam_awal', 'jam_akhir',
        'waktu', 'tanggal', 'app_1', 'app_2', 'tgl_app_1', 'tgl_app_2', 'approve_atasan', 'approve_sdi'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi dengan tabel user untuk karyawan yang mengikuti pelatihan
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan');
    }

    // Relasi dengan tabel user untuk atasan dari divisi karyawan
    public function atasan()
    {
        return $this->belongsTo(User::class, 'approve_atasan');
    }

    // Relasi dengan tabel user untuk SDI/HRD
    public function sdi()
    {
        return $this->belongsTo(User::class, 'approve_sdi');
    }
}
