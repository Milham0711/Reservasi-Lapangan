<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLegacy extends Model
{
    // A lightweight model to work with the legacy users_232112 table
    protected $table = 'users_232112';
    protected $primaryKey = 'user_id_232112';
    public $timestamps = false;

    protected $fillable = [
        'nama_232112',
        'email_232112',
        'telepon_232112',
        'password_232112',
        'role_232112',
        // friendly
        'name','email','phone','password','role',
    ];

    // If you want to use this model for authentication, you'll need to
    // implement the Authenticatable contract or map fields properly.
    protected $appends = ['id','name','email','phone','username','role','created_at_readable','updated_at_readable'];

    public function getIdAttribute()
    {
        return $this->attributes[$this->primaryKey] ?? null;
    }

    public function getNameAttribute()
    {
        return $this->attributes['nama_232112'] ?? null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['nama_232112'] = $value;
    }

    public function getEmailAttribute()
    {
        return $this->attributes['email_232112'] ?? null;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email_232112'] = $value;
    }

    public function getPhoneAttribute()
    {
        return $this->attributes['telepon_232112'] ?? null;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['telepon_232112'] = $value;
    }

    public function getUsernameAttribute()
    {
        return $this->attributes['username_232112'] ?? null;
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username_232112'] = $value;
    }

    public function getRoleAttribute()
    {
        return $this->attributes['role_232112'] ?? null;
    }

    public function getCreatedAtReadableAttribute()
    {
        return $this->attributes['created_at_232112'] ?? null;
    }

    public function getUpdatedAtReadableAttribute()
    {
        return $this->attributes['updated_at_232112'] ?? null;
    }
}

