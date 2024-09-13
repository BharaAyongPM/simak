<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiTambahan extends Model
{
    use HasFactory;
    protected $table = 'lokasi_tambahan';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['tanggal', 'shift', 'jam_masuk', 'jam_pulang', 'karyawan', 'divisi', 'unit'];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel karyawan, divisi, atau unit
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit');
    }
}
