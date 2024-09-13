<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    protected $table = 'notifikasi';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['tanggal', 'tgl_kirim', 'tgl_mingguan', 'tgl_bulanan', 'kegiatan', 'waktu', 'pesan'];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel lain
    // Misalnya, relasi dengan tabel pengguna atau penerima notifikasi
}
