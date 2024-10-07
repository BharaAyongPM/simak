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
    public function bag()
    {
        return $this->belongsTo(Bag::class, 'bagian', 'id_bagian'); // Foreign key adalah 'bagian' di tabel units dan primary key adalah 'id_bagian' di tabel bags
    }
    public function users()
    {
        return $this->hasMany(User::class, 'unit', 'id');
    }
}
