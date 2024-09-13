<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogNotifikasi extends Model
{
    use HasFactory;
    protected $table = 'log_notifikasi';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['kode_notif', 'tanggal'];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel lain
    // Misalnya, relasi dengan tabel notifikasi atau pengguna yang menerima notifikasi
}
