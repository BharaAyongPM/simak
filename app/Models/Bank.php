<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'bank',
        'rek',
    ];
}
