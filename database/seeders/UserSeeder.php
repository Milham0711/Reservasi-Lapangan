<?php

namespace Database\Seeders;

use App\Models\UserLegacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'nama_232112' => 'Admin User',
                'email_232112' => 'admin@example.com',
                'nomor_telepon_232112' => '081234567890',
                'username_232112' => 'admin',
                'password_232112' => Hash::make('password'),
                'role_232112' => 'admin',
            ],
            [
                'nama_232112' => 'Customer User',
                'email_232112' => 'customer@example.com',
                'nomor_telepon_232112' => '081234567891',
                'username_232112' => 'customer',
                'password_232112' => Hash::make('password'),
                'role_232112' => 'customer',
            ],
            [
                'nama_232112' => 'John Doe',
                'email_232112' => 'john@example.com',
                'nomor_telepon_232112' => '081234567892',
                'username_232112' => 'johndoe',
                'password_232112' => Hash::make('password'),
                'role_232112' => 'customer',
            ],
        ];

        foreach ($userData as $data) {
            UserLegacy::create($data);
        }
    }
}
