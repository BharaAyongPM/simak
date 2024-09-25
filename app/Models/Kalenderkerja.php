<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KalenderKerja extends Model
{
    use HasFactory;
    protected $table = 'kalenderkerja';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['tanggal', 'shift', 'jam_masuk', 'jam_pulang', 'karyawan', 'divisi', 'unit'];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel karyawan, divisi, atau unit
    public function karyn()
    {
        return $this->belongsTo(User::class, 'karyawan', 'id');
    }

    public function bag()
    {
        return $this->belongsTo(Bag::class, 'divisi', 'id_bagian');
    }

    public function unt()
    {
        return $this->belongsTo(Unit::class, 'unit', 'id'); // Sesuaikan dengan foreign key 'unit' di tabel users
    }
}
