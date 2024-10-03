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
        'unit',
        'nik',
        'jabatan',
        'tgl_masuk',
        'alamat',
        'no_telp',
        'status_kar',
        'kelamin',
        'agama',
        'tgl_lahir',
        'gaji',
        'shift',
        'absensi',
        'pot_dt',

    ];

    public $timestamps = true;

    // Relasi ke tabel 'bag' menggunakan foreign key 'divisi'
    public function bagian()
    {
        return $this->belongsTo(Bag::class, 'divisi'); // Kolom 'divisi' mengacu ke ID di tabel bag
    }
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
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
    public function hasRole($roleName)
    {
        return $this->roles->contains('name', $roleName);
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
