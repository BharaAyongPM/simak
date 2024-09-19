<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izin';  // Menentukan nama tabel yang digunakan oleh model

    protected $fillable = [
        'jenis',
        'tanggal_pengajuan',
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'dokumen',
        'approve_1',
        'approve_2',
    ];  // Kolom yang dapat diisi secara massal

    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Relasi dengan tabel User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');  // Relasi izin dengan user
    }
}
