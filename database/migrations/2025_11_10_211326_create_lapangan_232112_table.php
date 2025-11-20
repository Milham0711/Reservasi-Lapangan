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
        Schema::create('lapangan_232112', function (Blueprint $table) {
            $table->id('lapangan_id_232112');
            $table->string('nama_lapangan_232112', 100);
            $table->enum('jenis_lapangan_232112', ['futsal', 'badminton', 'sepak bola', 'basket', 'voli', 'tenis', 'bulu tangkis']);
            $table->decimal('harga_per_jam_232112', 10, 2);
            $table->text('deskripsi_232112')->nullable();
            $table->enum('status_232112', ['active', 'maintenance', 'inactive'])->default('active');
            $table->string('gambar_232112', 255)->nullable();
            $table->integer('kapasitas_232112');
            $table->timestamp('created_at_232112')->useCurrent();
            $table->timestamp('updated_at_232112')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangan_232112');
    }
};
