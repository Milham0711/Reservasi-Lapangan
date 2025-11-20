<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users_232112';
    protected $primaryKey = 'user_id_232112';
    
    const CREATED_AT = 'created_at_232112';
    const UPDATED_AT = 'updated_at_232112';

    protected $fillable = [
        'nama_232112',
        'email_232112',
        'password_232112',
        'role_232112',
        'telepon_232112',
    ];

    protected $hidden = [
        'password_232112',
    ];

    // Relasi dengan Reservasi
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'user_id_232112', 'user_id_232112');
    }

    // Relasi dengan Notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id_232112', 'user_id_232112');
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role_232112 === 'admin';
    }

    // Override getAuthPassword untuk custom password field
    public function getAuthPassword()
    {
        return $this->password_232112;
    }

    // Override getAuthIdentifierName untuk custom primary key
    public function getAuthIdentifierName()
    {
        return 'user_id_232112';
    }
}