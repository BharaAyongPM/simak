<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupData extends Model
{
    protected $table = 'backup_data';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'tanggal',
    ];
}
