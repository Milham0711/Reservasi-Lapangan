<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran_232112';
    protected $primaryKey = 'pembayaran_id_232112';
    public $timestamps = false;

    protected $fillable = [
        'reservasi_id_232112',
        'jumlah_pembayaran_232112',
        'metode_pembayaran_232112',
        'status_pembayaran_232112',
        'bukti_pembayaran_232112',
        'tanggal_pembayaran_232112',
        'verified_by_232112',
        // friendly names
        'reservasi_id','amount','method','status','proof','paid_at','verified_by',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id_232112', 'reservasi_id_232112');
    }
    
    protected $appends = ['id','reservasi_id','method','amount','status','proof','paid_at','verified_by'];

    public function getIdAttribute()
    {
        return $this->attributes[$this->primaryKey] ?? null;
    }

    public function getReservasiIdAttribute()
    {
        return $this->attributes['reservasi_id_232112'] ?? null;
    }

    public function getMethodAttribute()
    {
        return $this->attributes['metode_pembayaran_232112'] ?? null;
    }

    public function getAmountAttribute()
    {
        return isset($this->attributes['jumlah_pembayaran_232112']) ? (float) $this->attributes['jumlah_pembayaran_232112'] : null;
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status_pembayaran_232112'] ?? null;
    }

    public function getProofAttribute()
    {
        return $this->attributes['bukti_pembayaran_232112'] ?? null;
    }

    public function getPaidAtAttribute()
    {
        return $this->attributes['tanggal_pembayaran_232112'] ?? null;
    }

    public function getVerifiedByAttribute()
    {
        return $this->attributes['verified_by_232112'] ?? null;
    }

    // Setters for friendly attributes
    public function setReservasiIdAttribute($value)
    {
        $this->attributes['reservasi_id_232112'] = $value;
    }

    public function setMethodAttribute($value)
    {
        $this->attributes['metode_pembayaran_232112'] = $value;
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['jumlah_pembayaran_232112'] = $value;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status_pembayaran_232112'] = $value;
    }

    public function setProofAttribute($value)
    {
        $this->attributes['bukti_pembayaran_232112'] = $value;
    }

    public function setPaidAtAttribute($value)
    {
        $this->attributes['tanggal_pembayaran_232112'] = $value;
    }

    public function setVerifiedByAttribute($value)
    {
        $this->attributes['verified_by_232112'] = $value;
    }
}
