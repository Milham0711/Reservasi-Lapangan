<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi_232112';
    protected $primaryKey = 'reservasi_id_232112';
    public $timestamps = false;

    protected $fillable = [
        'user_id_232112',
        'lapangan_id_232112',
        'tanggal_reservasi_232112',
        'waktu_mulai_232112',
        'waktu_selesai_232112',
        'total_harga_232112',
        'status_reservasi_232112',
        'catatan_232112',
        'created_at_232112',
        'updated_at_232112'
    ];

    // Example relationship to Lapangan
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id_232112', 'lapangan_id_232112');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'reservasi_id_232112', 'reservasi_id_232112');
    }

    // Friendly attributes
    protected $appends = ['id', 'code', 'user_id', 'lapangan_id', 'date', 'start_time', 'end_time', 'duration_hours', 'total', 'status', 'created_at_readable'];

    public function getIdAttribute()
    {
        return $this->attributes[$this->primaryKey] ?? null;
    }

    public function getCodeAttribute()
    {
        return $this->attributes['kode_booking_232112'] ?? null;
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['kode_booking_232112'] = $value;
    }

    public function getUserIdAttribute()
    {
        return $this->attributes['user_id_232112'] ?? null;
    }

    public function getLapanganIdAttribute()
    {
        return $this->attributes['lapangan_id_232112'] ?? null;
    }

    public function getDateAttribute()
    {
        return $this->attributes['tanggal_reservasi_232112'] ?? null;
    }

    public function getStartTimeAttribute()
    {
        return $this->attributes['waktu_mulai_232112'] ?? null;
    }

    public function getEndTimeAttribute()
    {
        return $this->attributes['waktu_selesai_232112'] ?? null;
    }

    public function getDurationHoursAttribute()
    {
        // Calculate duration from start and end time
        if (isset($this->attributes['waktu_mulai_232112']) && isset($this->attributes['waktu_selesai_232112'])) {
            $start = strtotime($this->attributes['waktu_mulai_232112']);
            $end = strtotime($this->attributes['waktu_selesai_232112']);
            return ($end - $start) / 3600;
        }
        return null;
    }

    public function getTotalAttribute()
    {
        return isset($this->attributes['total_harga_232112']) ? (float) $this->attributes['total_harga_232112'] : null;
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status_reservasi_232112'] ?? null;
    }

    public function getCreatedAtReadableAttribute()
    {
        return $this->attributes['created_at_232112'] ?? null;
    }

    // Setters for friendly attributes (mass assignment support)
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id_232112'] = $value;
    }

    public function setLapanganIdAttribute($value)
    {
        $this->attributes['lapangan_id_232112'] = $value;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['tanggal_reservasi_232112'] = $value;
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['waktu_mulai_232112'] = $value;
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['waktu_selesai_232112'] = $value;
    }

    public function setDurationHoursAttribute($value)
    {
        // Duration is calculated from start and end time, not stored separately
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total_harga_232112'] = $value;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status_reservasi_232112'] = $value;
    }

}

