<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redeem extends Model
{
    use HasFactory;

    protected $table = 'redeem';

    protected $fillable = [
        'user_id',
        'hari_libur',
        'jam_yang_diredeem',
        'approve_1',
        'approve_2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
