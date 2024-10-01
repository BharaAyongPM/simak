<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = ['name']; // Nama role bisa diisi

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user'); // Relasi ke user melalui tabel pivot role_user
    }
}
