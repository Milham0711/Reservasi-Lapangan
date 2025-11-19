<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User232112Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nama_232112' => 'Admin SportVenue',
                'email_232112' => 'admin@sportvenue.com',
                'password_232112' => Hash::make('password'),
                'role_232112' => 'admin',
                'telepon_232112' => '081234567890',
                'created_at_232112' => now(),
                'updated_at_232112' => now(),
            ],
            [
                'nama_232112' => 'John Doe',
                'email_232112' => 'john@example.com',
                'password_232112' => Hash::make('password'),
                'role_232112' => 'user',
                'telepon_232112' => '081234567891',
                'created_at_232112' => now(),
                'updated_at_232112' => now(),
            ],
            [
                'nama_232112' => 'Jane Smith',
                'email_232112' => 'jane@example.com',
                'password_232112' => Hash::make('password'),
                'role_232112' => 'user',
                'telepon_232112' => '081234567892',
                'created_at_232112' => now(),
                'updated_at_232112' => now(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users_232112')->updateOrInsert(
                ['email_232112' => $user['email_232112']], // condition to check
                $user // data to insert or update
            );
        }
    }
}
