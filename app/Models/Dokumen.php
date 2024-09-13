<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $table = 'dokumen';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = ['dokumen', 'jenis', 'keterangan', 'created_at', 'updated_at'];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)
}
