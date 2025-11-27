<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Daftar semua nama tabel kamu di sini
        $tables = [
            'cities',
            'categories',
            'boarding_houses',
            'rooms',
            'room_images',
            'bonuses',
            'testimonials',
            'transactions',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->softDeletes(); 
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'cities', 'categories', 'boarding_houses', 'rooms', 
            'room_images', 'bonuses', 'testimonials', 'transactions'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};