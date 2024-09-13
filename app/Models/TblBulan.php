<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblBulan extends Model
{
    use HasFactory;
    protected $table = 'tbl_bulan';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['nama', 'kode', 'bulan'];  // Kolom yang dapat diisi secara massal
    public $timestamps = false;  // Tidak menggunakan timestamps (karena tidak ada kolom created_at atau updated_at)

    // Tambahkan lebih banyak fungsi jika diperlukan untuk mengelola bulan secara efektif
}
