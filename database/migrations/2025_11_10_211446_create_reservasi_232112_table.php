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
        Schema::create('reservasi_232112', function (Blueprint $table) {
            $table->id('reservasi_id_232112');
            $table->unsignedBigInteger('user_id_232112');
            $table->unsignedBigInteger('lapangan_id_232112');
            $table->date('tanggal_reservasi_232112');
            $table->time('waktu_mulai_232112');
            $table->time('waktu_selesai_232112');
            $table->decimal('total_harga_232112', 10, 2);
            $table->enum('status_reservasi_232112', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->text('catatan_232112')->nullable();
            $table->timestamp('created_at_232112')->useCurrent();
            $table->timestamp('updated_at_232112')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id_232112')->references('user_id_232112')->on('users_232112')->onDelete('cascade');
            $table->foreign('lapangan_id_232112')->references('lapangan_id_232112')->on('lapangan_232112')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi_232112');
    }
};
