<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CariBk extends Model
{
    protected $table = 'cari_bk';
    public $timestamps = false;

    protected $fillable = [
        'id_bon',
        'id_kategori',
        'stok',
        'id_kategoripr'
    ];
}
