<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    protected $table = 'tagihan';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'kode_karyawan', 'jumlah', 'bulan', 'tahun', 'status_tagihan', 'keterangan',
        'tgl_bayar', 'tanggal', 'jenis'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi dengan tabel user untuk karyawan yang memiliki tagihan
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'kode_karyawan');  // 'kode_karyawan' adalah FK di tabel tagihan yang mengacu pada 'id' di tabel user
    }

    // Tambahkan lebih banyak fungsi jika diperlukan untuk mengelola tagihan secara efektif
}
