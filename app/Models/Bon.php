<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bon extends Model
{
    protected $table = 'bon';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'tanggal',
        'jenis',
        'karyawan',
        'nilai',
        'keperluan',
        'angsuran',
        'mulai_potong',
        'divisi',
        'approve_1',
        'approve_2',
        'catatan',
        'catatan_keuangan',
        'fhoto',
        'cetak',
        'jumlah_cicilan',
        'tahun',
        'status_pinjaman',
        'tgl_app_1',
        'tgl_app_2',
        'done',
    ];
}
