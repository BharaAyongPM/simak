<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'bagian',
        'unit'
    ];
    public function bagian()
    {
        return $this->belongsTo(Bag::class, 'bagian_id'); // 'bagian_id' adalah foreign key di tabel 'units'
    }
    public function users()
    {
        return $this->hasMany(User::class, 'unit', 'id');
    }
}
