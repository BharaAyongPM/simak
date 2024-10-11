<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatangTerlambat extends Model
{
    use HasFactory;
    protected $table = 'datang_terlambat';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'tanggal',
        'karyawan',
        'keterangan',
        'app_1',
        'app_2',
        'tgl_app_1',
        'tgl_app_2',
        'approve_atasan',
        'approve_sdi',
        'keterangan1',
        'keterangan2'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi dengan tabel user untuk karyawan yang terlambat
    public function karyn()
    {
        return $this->belongsTo(User::class, 'karyawan', 'id');
    }

    // Relasi dengan tabel user untuk approval atasan
    public function approveAtasan()
    {
        return $this->belongsTo(User::class, 'approve_atasan');
    }

    // Relasi dengan tabel user untuk approval SDI
    public function approveSdi()
    {
        return $this->belongsTo(User::class, 'approve_sdi');
    }
}
