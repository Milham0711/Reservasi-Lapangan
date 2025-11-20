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
        // Add missing columns if they don't exist
        $columns = Schema::getColumnListing('pembayaran_232112');
        
        if (!in_array('transaction_id_midtrans', $columns)) {
            Schema::table('pembayaran_232112', function (Blueprint $table) {
                $table->string('transaction_id_midtrans', 255)->nullable();
            });
        }
        
        if (!in_array('payment_url', $columns)) {
            Schema::table('pembayaran_232112', function (Blueprint $table) {
                $table->string('payment_url', 500)->nullable();
            });
        }
        
        if (!in_array('tanggal_pembayaran_232112', $columns)) {
            Schema::table('pembayaran_232112', function (Blueprint $table) {
                $table->timestamp('tanggal_pembayaran_232112')->nullable();
            });
        }
        
        // Update column sizes if they exist
        if (in_array('metode_pembayaran_232112', $columns)) {
            Schema::table('pembayaran_232112', function (Blueprint $table) {
                $table->string('metode_pembayaran_232112', 50)->change();
            });
        }
        
        if (in_array('status_pembayaran_232112', $columns)) {
            Schema::table('pembayaran_232112', function (Blueprint $table) {
                $table->string('status_pembayaran_232112', 50)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran_232112', function (Blueprint $table) {
            $table->dropColumn([
                'transaction_id_midtrans',
                'payment_url', 
                'tanggal_pembayaran_232112'
            ]);
        });
    }
};