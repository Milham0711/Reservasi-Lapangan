<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_232112';
    protected $primaryKey = 'pembayaran_id_232112';

    protected $fillable = [
        'reservasi_id_232112',
        'metode_pembayaran_232112',
        'jumlah_pembayaran_232112',
        'status_pembayaran_232112',
        'transaction_id_midtrans',
        'payment_url',
        'tanggal_pembayaran_232112',
    ];

    const CREATED_AT = 'created_at_232112';
    const UPDATED_AT = 'updated_at_232112';

    // Relasi dengan Reservasi
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id_232112', 'reservasi_id_232112');
    }
}