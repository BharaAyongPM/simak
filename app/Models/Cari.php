<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cari extends Model
{
    protected $table = 'cari';
    protected $primaryKey = 'id_cari';
    public $timestamps = true;

    protected $fillable = [
        'id_bon',
        'id_kategori',
        'stok',
        'id_kategoripr',
        'stokpr',
        'supplier',
        'nop',
        'tipe',
        'kode',
        'tiperetur',
        'awal',
        'akhir',
        'laporan',
        'status_pp',
        'shift',
        'tgl_produksi',
        'status_rph',
        'tgl_sp',
        'status_qc',
        'cetak_sj',
        'tgl_kirim',
        'tgl_spb',
        'status_spb',
        'status_spk',
        'divisi',
        'status_lpts',
        'kashift',
        'bulan',
        'tahun',
        'status_bon',
        'unit',
        'keputusan',
        'karyawan',
        'kehadiran',
        'bon',
        'karyawan_banyak',
        'shift_1',
        'shift_2',
        'shift_3'
    ];
}
