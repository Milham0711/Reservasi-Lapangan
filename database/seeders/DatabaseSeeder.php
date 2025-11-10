<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Note: Using legacy tables (users_232112, etc.), so skipping default User factory
        // Uncomment below if you want to seed default Laravel users table
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            User232112Seeder::class,
            Lapangan232112Seeder::class,
        ]);
    }
}
