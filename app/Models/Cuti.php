<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan
    protected $table = 'cuti';

    // Tentukan kolom yang bisa diisi secara massal
    protected $fillable = [
        'tanggal_pengajuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_cuti_id',  // Merujuk ke tabel jenis cuti
        'user_id',        // ID user yang mengajukan cuti
        'sisa_cuti',      // Sisa cuti diambil dari stok cuti
        'keterangan',
        'approve_1',
        'approve_2'
    ];

    // Relasi ke tabel jenis cuti
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenisCuti()
    {
        return $this->belongsTo(JenisCuti::class, 'jenis_cuti_id');
    }

    // Relasi ke tabel stok cuti (untuk sisa cuti)
    public function stokCuti()
    {
        return $this->hasOne(StokCuti::class, 'user_id', 'user_id');
    }
}
