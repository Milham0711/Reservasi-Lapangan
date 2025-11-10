<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalLapangan extends Model
{
    protected $table = 'jadwal_lapangan_232112';
    protected $primaryKey = 'jadwal_id_232112';
    public $timestamps = false;

    protected $fillable = [
        'lapangan_id_232112',
        'hari_232112',
        'jam_buka_232112',
        'jam_tutup_232112',
        // friendly names
        'lapangan_id','day','open_time','close_time',
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id_232112', 'lapangan_id_232112');
    }

    protected $appends = ['id','lapangan_id','day','open_time','close_time'];

    public function getIdAttribute()
    {
        return $this->attributes[$this->primaryKey] ?? null;
    }

    public function getLapanganIdAttribute()
    {
        return $this->attributes['lapangan_id_232112'] ?? null;
    }

    public function getDayAttribute()
    {
        return $this->attributes['hari_232112'] ?? null;
    }

    public function getOpenTimeAttribute()
    {
        return $this->attributes['jam_buka_232112'] ?? null;
    }

    public function getCloseTimeAttribute()
    {
        return $this->attributes['jam_tutup_232112'] ?? null;
    }

    // Setters for friendly attributes
    public function setLapanganIdAttribute($value)
    {
        $this->attributes['lapangan_id_232112'] = $value;
    }

    public function setDayAttribute($value)
    {
        $this->attributes['hari_232112'] = $value;
    }

    public function setOpenTimeAttribute($value)
    {
        $this->attributes['jam_buka_232112'] = $value;
    }

    public function setCloseTimeAttribute($value)
    {
        $this->attributes['jam_tutup_232112'] = $value;
    }
}
