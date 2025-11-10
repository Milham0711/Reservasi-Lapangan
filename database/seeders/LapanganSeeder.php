<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LapanganSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lapanganData = [
            [
                'nama_lapangan_232112' => 'Lapangan Futsal Vinyl A',
                'jenis_lapangan_232112' => 'futsal',
                'harga_per_jam_232112' => 50000,
                'deskripsi_232112' => 'Lapangan futsal indoor dengan lantai vinyl berkualitas tinggi, cocok untuk pertandingan resmi.',
                'status_232112' => 'active',
                'gambar_232112' => 'images/futsal-vinyl.jpg',
            ],
            [
                'nama_lapangan_232112' => 'Lapangan Futsal Sintetis B',
                'jenis_lapangan_232112' => 'futsal',
                'harga_per_jam_232112' => 40000,
                'deskripsi_232112' => 'Lapangan futsal dengan rumput sintetis, ideal untuk latihan dan pertandingan santai.',
                'status_232112' => 'active',
                'gambar_232112' => 'images/futsal-synthetic.jpg',
            ],
            [
                'nama_lapangan_232112' => 'Lapangan Badminton Indoor 1',
                'jenis_lapangan_232112' => 'badminton',
                'harga_per_jam_232112' => 80000,
                'deskripsi_232112' => 'Lapangan badminton indoor standar nasional dengan pencahayaan optimal.',
                'status_232112' => 'active',
                'gambar_232112' => 'images/badminton-indoor-1.jpg',
            ],
            [
                'nama_lapangan_232112' => 'Lapangan Badminton Indoor 2',
                'jenis_lapangan_232112' => 'badminton',
                'harga_per_jam_232112' => 80000,
                'deskripsi_232112' => 'Lapangan badminton indoor dengan fasilitas lengkap untuk turnamen.',
                'status_232112' => 'active',
                'gambar_232112' => 'images/badminton-indoor-2.jpg',
            ],
            [
                'nama_lapangan_232112' => 'Lapangan Badminton Indoor 3',
                'jenis_lapangan_232112' => 'badminton',
                'harga_per_jam_232112' => 80000,
                'deskripsi_232112' => 'Lapangan badminton indoor dengan sistem pendingin udara.',
                'status_232112' => 'active',
                'gambar_232112' => 'images/badminton-indoor-3.jpg',
            ],
        ];

        foreach ($lapanganData as $data) {
            Lapangan::create($data);
        }
    }
}
