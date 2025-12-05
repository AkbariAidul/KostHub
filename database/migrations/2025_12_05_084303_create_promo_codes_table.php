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
    Schema::create('promo_codes', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Misal: MABA2025
        $table->text('description')->nullable();
        $table->string('type')->default('fixed'); // 'fixed' (potongan harga) atau 'percentage' (persen)
        $table->integer('discount_amount'); // Besar potongan (misal: 50000 atau 10 persen)
        $table->datetime('valid_from');
        $table->datetime('valid_until');
        $table->integer('usage_limit')->default(100); // Batas berapa kali kode bisa dipakai
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
