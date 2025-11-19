<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Lapangan232112Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lapangan_232112')->insert([
            [
                'nama_lapangan_232112' => 'Lapangan Futsal A',
                'jenis_lapangan_232112' => 'futsal',
                'harga_per_jam_232112' => 50000.00,
                'deskripsi_232112' => 'Lapangan futsal indoor dengan kualitas premium',
                'status_232112' => 'active',
                'gambar_232112' => 'images/futsal-a.jpg',
                'kapasitas_232112' => 20,
                'created_at_232112' => now(),
                'updated_at_232112' => now(),
            ],
            [
                'nama_lapangan_232112' => 'Lapangan Futsal B',
                'jenis_lapangan_232112' => 'futsal',
                'harga_per_jam_232112' => 45000.00,
                'deskripsi_232112' => 'Lapangan futsal outdoor dengan pencahayaan LED',
                'status_232112' => 'active',
                'gambar_232112' => 'images/futsal-b.jpg',
                'kapasitas_232112' => 20,
                'created_at_232112' => now(),
                'updated_at_232112' => now(),
            ],
            [
                'nama_lapangan_232112' => 'Lapangan Badminton 1',
                'jenis_lapangan_232112' => 'badminton',
                'harga_per_jam_232112' => 30000.00,
                'deskripsi_232112' => 'Lapangan badminton indoor dengan net berkualitas',
                'status_232112' => 'active',
                'gambar_232112' => 'images/badminton-1.jpg',
                'kapasitas_232112' => 20,
                'created_at_232112' => now(),
                'updated_at_232112' => now(),
            ],
            [
                'nama_lapangan_232112' => 'Lapangan Badminton 2',
                'jenis_lapangan_232112' => 'badminton',
                'harga_per_jam_232112' => 35000.00,
                'deskripsi_232112' => 'Lapangan badminton dengan fasilitas lengkap',
                'status_232112' => 'active',
                'gambar_232112' => 'images/badminton-2.jpg',
                'kapasitas_232112' => 20,
                'created_at_232112' => now(),
                'updated_at_232112' => now(),
            ],
            [
                'nama_lapangan_232112' => 'Lapangan Badminton 3',
                'jenis_lapangan_232112' => 'badminton',
                'harga_per_jam_232112' => 32000.00,
                'deskripsi_232112' => 'Lapangan badminton untuk turnamen',
                'status_232112' => 'active',
                'gambar_232112' => 'images/badminton-3.jpg',
                'kapasitas_232112' => 10,
                'created_at_232112' => now(),
                'updated_at_232112' => now(),
            ],
        ]);
    }
}
