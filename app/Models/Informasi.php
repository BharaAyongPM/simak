<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    protected $table = 'informasi';  // Menentukan nama tabel yang digunakan oleh model

    protected $fillable = [
        'tanggal',
        'informasi',
        'foto',
        'status_informasi',
        'bagian', // Relasi ke bagian
        'unit',   // Relasi ke unit
        'jenis',
        'user_id',  // ID user yang mengirimkan informasi
        'display_info',
        'unit_banyak' // Jika ada unit yang diatur banyak
    ];  // Kolom yang dapat diisi secara massal

    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Relasi ke tabel Bagian
    public function bag()
    {
        return $this->belongsTo(Bag::class, 'bagian', 'id_bagian'); // 'bagian' adalah foreign key di tabel informasi
    }

    // Relasi ke tabel Unit
    public function unt()
    {
        return $this->belongsTo(Unit::class, 'unit', 'id'); // 'unit' adalah foreign key di tabel informasi
    }
}
