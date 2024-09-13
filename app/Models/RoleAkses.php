<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAkses extends Model
{
    use HasFactory;
    protected $table = 'roleakses';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'tambah', 'edit', 'hapus', 'cetak', 'akses', 'menu', 'submenu1',
        'alamat', 'divisi', 'urut', 'id_menu'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan fungsi relasi jika ada kebutuhan terkait relasi dengan tabel divisi atau menu
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}
