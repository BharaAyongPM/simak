<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'setting';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'nama_perusahaan', 'alamat', 'telepon', 'logo', 'kartu_member', 'diskon_member',
        'tipe_nota', 'person', 'bank', 'cabang', 'rekening', 'dt', 'alpa', 'f_ig', 'f_fb',
        'shift_1', 'v_ig', 'v_fb', 'hak_cuti', 'jarak', 'lat', 'lon', 'toleransi_masuk',
        'masuk_1', 'pulang_1', 'masuk_2', 'pulang_2', 'masuk_3', 'pulang_3', 'masuk_nonshift',
        'pulang_nonshift', 'pot_dt_1', 'pot_dt_2', 'pot_dt_3'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tidak ada relasi khusus yang ditambahkan di sini kecuali diperlukan
}
