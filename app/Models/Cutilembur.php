<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutilembur extends Model
{
    use HasFactory;
    protected $table = 'cutilembur';  // Menentukan nama tabel yang digunakan oleh model
    protected $fillable = [
        'tanggal',
        'karyawan',
        'tgl_cl',
        'jam_mulai',
        'jam_akhir',
        'keterangan',
        'created_at',
        'updated_at',
        'divisi',
        'approve_1',
        'approve_2',
        'catatan',
        'catatan_hr',
        'jenis',
        'pic',
        'fhoto',
        'waktu',
        'status_lembur',
        'rupiah',
        'potong_cuti',
        'approve_atasan',
        'approve_sdi'
    ];  // Kolom yang dapat diisi secara massal
    public $timestamps = true;  // Menggunakan timestamps (created_at, updated_at)

    public function karyn()
    {
        return $this->belongsTo(User::class, 'karyawan', 'id');  // 'karyawan' adalah FK di tabel absensi yang mengacu pada 'id' di tabel user
    }
    public function bag()
    {
        return $this->belongsTo(Bag::class, 'divisi', 'id_bagian');
    }
}
