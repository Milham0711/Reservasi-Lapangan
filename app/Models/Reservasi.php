<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi_232112';
    protected $primaryKey = 'reservasi_id_232112';
    
    const CREATED_AT = 'created_at_232112';
    const UPDATED_AT = 'updated_at_232112';

    protected $fillable = [
        'user_id_232112',
        'lapangan_id_232112',
        'tanggal_reservasi_232112',
        'waktu_mulai_232112',
        'waktu_selesai_232112',
        'total_harga_232112',
        'status_reservasi_232112',
        'catatan_232112',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id_232112', 'user_id_232112');
    }

    // Relasi dengan Lapangan
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id_232112', 'lapangan_id_232112');
    }

    // Relasi dengan Pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'reservasi_id_232112', 'reservasi_id_232112');
    }

    // Scope untuk filter berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('status_reservasi_232112', $status);
    }

    // Scope untuk reservasi hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_reservasi_232112', today());
    }
}