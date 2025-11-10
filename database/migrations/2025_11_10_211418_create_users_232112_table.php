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
        Schema::create('users_232112', function (Blueprint $table) {
            $table->id('user_id_232112');
            $table->string('nama_232112', 100);
            $table->string('email_232112', 100)->unique();
            $table->string('password_232112');
            $table->enum('role_232112', ['admin', 'user'])->default('user');
            $table->string('telepon_232112', 20)->nullable();
            $table->timestamp('created_at_232112')->useCurrent();
            $table->timestamp('updated_at_232112')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_232112');
    }
};
