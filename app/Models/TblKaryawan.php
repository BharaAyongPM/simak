<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblKaryawan extends Model
{
    use HasFactory;
    protected $table = 'tbl_karyawan';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'nama', 'nik', 'divisi', 'jabatan', 'tgl_masuk', 'alamat', 'no_telp', 'status_kar',
        'email', 'level', 'aktif', 'tgl_mulai', 'tgl_akhir', 'kelamin', 'agama', 'tgl_lahir',
        'gaji', 'approve', 'deposit', 'shift', 'grup', 'absensi', 'pot_dt', 'unit', 'nama_unit'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    // Tambahkan relasi untuk tabel terkait jika diperlukan
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit');
    }
}
