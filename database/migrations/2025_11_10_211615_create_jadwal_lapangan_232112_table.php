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
        Schema::create('jadwal_lapangan_232112', function (Blueprint $table) {
            $table->id('jadwal_id_232112');
            $table->unsignedBigInteger('lapangan_id_232112');
            $table->date('tanggal_232112');
            $table->time('waktu_mulai_232112');
            $table->time('waktu_selesai_232112');
            $table->enum('status_jadwal_232112', ['available', 'booked', 'maintenance'])->default('available');
            $table->timestamp('created_at_232112')->useCurrent();
            $table->timestamp('updated_at_232112')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('lapangan_id_232112')->references('lapangan_id_232112')->on('lapangan_232112')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_lapangan_232112');
    }
};
