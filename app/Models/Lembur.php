<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lembur';

    // Field yang bisa diisi massal
    protected $fillable = [
        'user_id',
        'tanggal_pengajuan',
        'tanggal_lembur',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
        'dokumen',
        'approve_1',
        'approve_2',
        'jenis_lembur',
        'total_jam',
        'deposit_jam',
        'rate_per_jam',
        'total_bayar',
        'redeemed',
        'total_bayar'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Mendapatkan total durasi lembur
    public function getDurasiLemburAttribute()
    {
        $jamMulai = \Carbon\Carbon::parse($this->jam_mulai);
        $jamSelesai = \Carbon\Carbon::parse($this->jam_selesai);
        return $jamSelesai->diffInHours($jamMulai);
    }

    // Mendapatkan apakah lembur adalah lembur deposit
    public function isDeposit()
    {
        return $this->jenis_lembur == 'deposit';
    }

    // Mendapatkan apakah lembur sudah ditebus
    public function isRedeemed()
    {
        return $this->redeemed;
    }
}
