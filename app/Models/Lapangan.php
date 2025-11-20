<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $table = 'lapangan_232112';
    protected $primaryKey = 'lapangan_id_232112';
    
    const CREATED_AT = 'created_at_232112';
    const UPDATED_AT = 'updated_at_232112';

    protected $fillable = [
        'nama_lapangan_232112',
        'jenis_lapangan_232112',
        'harga_per_jam_232112',
        'deskripsi_232112',
        'status_232112',
        'gambar_232112',
        'kapasitas_232112',
    ];

    // Relasi dengan Reservasi
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'lapangan_id_232112', 'lapangan_id_232112');
    }

    // Relasi dengan Jadwal
    public function jadwal()
    {
        return $this->hasMany(JadwalLapangan::class, 'lapangan_id_232112', 'lapangan_id_232112');
    }

    // Scope untuk filter berdasarkan jenis
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_lapangan_232112', $jenis);
    }

    // Scope untuk lapangan aktif
    public function scopeActive($query)
    {
        return $query->where('status_232112', 'active');
    }
}