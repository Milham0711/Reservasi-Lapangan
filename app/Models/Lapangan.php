<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $table = 'lapangan_232112';
    protected $primaryKey = 'lapangan_id_232112';
    public $timestamps = false;

    protected $fillable = [
        'nama_lapangan_232112',
        'jenis_lapangan_232112',
        'harga_per_jam_232112',
        'deskripsi_232112',
        'status_232112',
        'gambar_232112',
        'kapasitas_232112',
        // friendly names for mass assignment
        'name', 'type', 'price', 'description', 'status', 'image', 'capacity'
    ];

    // Expose friendly attribute names and include them when serializing
    protected $appends = ['id', 'name', 'type', 'price', 'description', 'status', 'image', 'created_at_readable', 'capacity'];

    // Accessors
    public function getIdAttribute()
    {
        return $this->attributes[$this->primaryKey] ?? null;
    }

    public function getNameAttribute()
    {
        return $this->attributes['nama_lapangan_232112'] ?? null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['nama_lapangan_232112'] = $value;
    }

    public function getTypeAttribute()
    {
        return $this->attributes['jenis_lapangan_232112'] ?? null;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['jenis_lapangan_232112'] = $value;
    }

    public function getPriceAttribute()
    {
        return isset($this->attributes['harga_per_jam_232112']) ? (float) $this->attributes['harga_per_jam_232112'] : null;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['harga_per_jam_232112'] = $value;
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['deskripsi_232112'] ?? null;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['deskripsi_232112'] = $value;
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status_232112'] ?? null;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status_232112'] = $value;
    }

    public function getImageAttribute()
    {
        return $this->attributes['gambar_232112'] ?? null;
    }

    public function setImageAttribute($value)
    {
        $this->attributes['gambar_232112'] = $value;
    }

    public function getCapacityAttribute()
    {
        return $this->attributes['kapasitas_232112'] ?? null;
    }

    public function setCapacityAttribute($value)
    {
        $this->attributes['kapasitas_232112'] = $value;
    }
    
    public function getCreatedAtReadableAttribute()
    {
        return $this->attributes['created_at_232112'] ?? null;
    }

    // Relationship with Reservasi
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'lapangan_id_232112', 'lapangan_id_232112');
    }
}
