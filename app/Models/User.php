<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
        'level',
        'divisi',
        'aktif',
        'tgl_mulai',
        'tgl_akhir',
        'unit'
    ];

    public $timestamps = true;

    // Relasi ke tabel 'bag' menggunakan foreign key 'divisi'
    public function bag()
    {
        return $this->belongsTo(Bag::class, 'divisi', 'id_bagian');
    }

    public function unt()
    {
        return $this->belongsTo(Unit::class, 'unit', 'id'); // Sesuaikan dengan foreign key 'unit' di tabel users
    }

    public function lv()
    {
        return $this->belongsTo(Level::class, 'level', 'id'); // Sesuaikan dengan foreign key 'level' di tabel users
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
