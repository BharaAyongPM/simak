<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'nama', 'alamat', 'telepon', 'email', 'departemen_id'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi ke Departemen
    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
}
