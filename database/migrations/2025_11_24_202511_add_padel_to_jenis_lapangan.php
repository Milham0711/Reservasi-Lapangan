<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum column to include 'padel'
        \DB::statement("ALTER TABLE lapangan_232112 MODIFY COLUMN jenis_lapangan_232112 ENUM('futsal', 'badminton', 'sepak bola', 'basket', 'voli', 'tenis', 'bulu tangkis', 'padel')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the enum column to exclude 'padel'
        \DB::statement("ALTER TABLE lapangan_232112 MODIFY COLUMN jenis_lapangan_232112 ENUM('futsal', 'badminton', 'sepak bola', 'basket', 'voli', 'tenis', 'bulu tangkis')");
    }
};
