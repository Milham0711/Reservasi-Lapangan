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
        Schema::create('pembayaran_232112', function (Blueprint $table) {
            $table->id('pembayaran_id_232112');
            $table->unsignedBigInteger('reservasi_id_232112');
            $table->string('metode_pembayaran_232112', 50);
            $table->decimal('jumlah_pembayaran_232112', 10, 2);
            $table->string('status_pembayaran_232112', 50)->default('pending');
            $table->timestamp('created_at_232112')->useCurrent();
            $table->timestamp('updated_at_232112')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('reservasi_id_232112')->references('reservasi_id_232112')->on('reservasi_232112')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_232112');
    }
};
