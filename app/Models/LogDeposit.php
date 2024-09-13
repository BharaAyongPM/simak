<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogDeposit extends Model
{
    use HasFactory;
    protected $table = 'log_deposit';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['tanggal', 'karyawan', 'jumlah'];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel karyawan atau tabel lain
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan');
    }
}
