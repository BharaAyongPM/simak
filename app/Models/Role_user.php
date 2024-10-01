<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{
    use HasFactory;
    protected $table = 'role_user';
    protected $fillable = ['user_id', 'role_id']; // Nama role bisa diisi
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user'); // Relasi ke roles melalui tabel pivot role_user
    }

    // Fungsi tambahan untuk mengecek apakah user memiliki role tertentu
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
