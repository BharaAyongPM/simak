<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;
    protected $table = 'tahun';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['nama'];  // Kolom yang dapat diisi secara massal
    public $timestamps = false;  // Tidak menggunakan timestamps (karena tidak ada kolom created_at atau updated_at)
}
