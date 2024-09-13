<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    use HasFactory;
    protected $table = 'slipgaji';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'karyawan', 'gaji_pokok', 'tunj_prestasi', 'tunj_makan', 'tunj_transport',
        'tunj_jabatan', 'tunj_kehadiran', 'tunj_jamsostek', 'pph', 'pot_jamsostek',
        'nama', 'pot_alpa', 'pot_sakit', 'pot_jamsostek_pribadi', 'periode'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel karyawan atau tabel lain
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan');
    }
}
