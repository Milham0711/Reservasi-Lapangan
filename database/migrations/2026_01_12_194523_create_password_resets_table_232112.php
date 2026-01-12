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
        Schema::create('password_resets_232112', function (Blueprint $table) {
            $table->id('reset_id_232112');
            $table->string('email_232112');
            $table->string('token_232112');
            $table->timestamp('created_at_232112')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_resets_232112');
    }
};
