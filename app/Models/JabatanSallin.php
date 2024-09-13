<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanSallin extends Model
{
    use HasFactory;
    protected $table = 'jabatan_sallin';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'nama', 'departement', 'approve', 'id_dept', 'unit', 'nama_unit',
        'dep_app', 'unit_app', 'jabatan_app'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada relasi dengan tabel departement atau unit atau tabel lain
    // Misalnya relasi ke tabel Departemen
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'id_dept');
    }
}
