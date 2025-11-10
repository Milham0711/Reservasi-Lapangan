<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi_232112';
    protected $primaryKey = 'notifikasi_id_232112';
    public $timestamps = false;

    protected $fillable = [
        'user_id_232112',
        'judul_notifikasi_232112',
        'isi_notifikasi_232112',
        'tipe_notifikasi_232112',
        'sudah_dibaca_232112',
        // friendly
        'user_id','title','message','type','status',
    ];

    public function user()
    {
        return $this->belongsTo(UserLegacy::class, 'user_id_232112', 'user_id_232112');
    }

    protected $appends = ['id','user_id','title','message','type','status','created_at_readable'];

    public function getIdAttribute()
    {
        return $this->attributes[$this->primaryKey] ?? null;
    }

    public function getUserIdAttribute()
    {
        return $this->attributes['user_id_232112'] ?? null;
    }

    public function getTitleAttribute()
    {
        return $this->attributes['judul_notifikasi_232112'] ?? null;
    }

    public function getMessageAttribute()
    {
        return $this->attributes['isi_notifikasi_232112'] ?? null;
    }

    public function getTypeAttribute()
    {
        return $this->attributes['tipe_notifikasi_232112'] ?? null;
    }

    public function getStatusAttribute()
    {
        return $this->attributes['sudah_dibaca_232112'] ?? null;
    }

    public function getCreatedAtReadableAttribute()
    {
        return $this->attributes['created_at_232112'] ?? null;
    }
    
    // Setters for friendly attributes
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id_232112'] = $value;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['judul_notifikasi_232112'] = $value;
    }

    public function setMessageAttribute($value)
    {
        $this->attributes['isi_notifikasi_232112'] = $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['tipe_notifikasi_232112'] = $value;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['sudah_dibaca_232112'] = $value;
    }
}
