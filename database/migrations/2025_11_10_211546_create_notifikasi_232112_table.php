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
        Schema::create('notifikasi_232112', function (Blueprint $table) {
            $table->id('notifikasi_id_232112');
            $table->unsignedBigInteger('user_id_232112');
            $table->string('judul_notifikasi_232112', 255);
            $table->text('isi_notifikasi_232112');
            $table->enum('tipe_notifikasi_232112', ['info', 'warning', 'success', 'error']);
            $table->boolean('sudah_dibaca_232112')->default(false);
            $table->timestamp('created_at_232112')->useCurrent();
            $table->timestamp('updated_at_232112')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id_232112')->references('user_id_232112')->on('users_232112')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi_232112');
    }
};
