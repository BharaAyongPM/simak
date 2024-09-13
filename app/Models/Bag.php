<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    protected $table = 'bag';
    protected $primaryKey = 'id_bagian'; // Kunci utama tabel
    public $timestamps = true;

    protected $fillable = [
        'nama_bagian', // Kolom yang akan diakses
    ];
}
