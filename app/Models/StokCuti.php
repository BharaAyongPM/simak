<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokCuti extends Model
{
    use HasFactory;
    protected $table = 'stok_cuti';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'karyawan', 'awal_cuti', 'akhir_cuti', 'jumlah', 'pakai', 'sisa', 'tukar', 'jenis_cuti'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi dengan tabel user untuk karyawan yang memiliki stok cuti
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan');  // 'karyawan' adalah FK di tabel stok_cuti yang mengacu pada 'id' di tabel user
    }

    // Tambahkan lebih banyak fungsi jika diperlukan untuk mengelola stok cuti secara efektif
}
