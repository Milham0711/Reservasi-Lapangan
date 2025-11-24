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

    /**
     * Cek apakah waktu reservasi baru tumpang tindih dengan reservasi yang sudah ada
     */
    public static function isTimeSlotAvailable($lapanganId, $tanggal, $waktuMulai, $waktuSelesai, $excludeReservasiId = null)
    {
        $query = self::where('lapangan_id_232112', $lapanganId)
                    ->where('tanggal_reservasi_232112', $tanggal)
                    ->where(function($q) use ($waktuMulai, $waktuSelesai) {
                        // Cek apakah waktu baru tumpang tindih dengan waktu reservasi yang sudah ada
                        // Tumpang tindih terjadi jika:
                        // 1. Waktu mulai baru sebelum waktu selesai reservasi lama, DAN
                        // 2. Waktu selesai baru setelah waktu mulai reservasi lama
                        $q->where(function($q2) use ($waktuMulai, $waktuSelesai) {
                            $q2->where('waktu_mulai_232112', '<', $waktuSelesai)
                               ->where('waktu_selesai_232112', '>', $waktuMulai);
                        });
                    });

        // Exclude reservasi saat update (jika ada ID yang ingin dikecualikan)
        if ($excludeReservasiId) {
            $query->where('reservasi_id_232112', '!=', $excludeReservasiId);
        }

        // Hanya periksa reservasi yang belum dibatalkan
        $query->where('status_reservasi_232112', '!=', 'cancelled');

        return $query->count() === 0;
    }

    /**
     * Mendapatkan semua slot waktu yang sudah terisi untuk lapangan dan tanggal tertentu
     */
    public static function getOccupiedTimeSlots($lapanganId, $tanggal)
    {
        return self::where('lapangan_id_232112', $lapanganId)
                   ->where('tanggal_reservasi_232112', $tanggal)
                   ->where('status_reservasi_232112', '!=', 'cancelled')
                   ->select('waktu_mulai_232112', 'waktu_selesai_232112')
                   ->get();
    }

    /**
     * Mendapatkan semua slot waktu yang sudah terisi dalam rentang waktu untuk ditampilkan
     */
    public static function getOccupiedTimeSlotsForDisplay($lapanganId, $tanggal, $startHour = 0, $endHour = 23)
    {
        $occupiedSlots = self::getOccupiedTimeSlots($lapanganId, $tanggal);
        $result = [];

        foreach ($occupiedSlots as $slot) {
            $waktuMulai = $slot->waktu_mulai_232112;
            $waktuSelesai = $slot->waktu_selesai_232112;

            // Parse waktu mulai dan selesai
            $start = \Carbon\Carbon::parse($waktuMulai);
            $end = \Carbon\Carbon::parse($waktuSelesai);

            // Tambahkan semua jam dalam rentang waktu tersebut sebagai terisi
            while ($start->lt($end)) {
                $hour = $start->format('H:i');
                $result[] = $hour;
                $start->addHour(); // Tambah 1 jam

                // Pastikan kita tidak melampaui waktu selesai
                if ($start->format('H:i') > $waktuSelesai && $start->format('i') > 0) {
                    break;
                }
            }
        }

        return array_unique($result);
    }
}