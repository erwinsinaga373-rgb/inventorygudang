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
        Schema::table('barangs', function (Blueprint $table) {
            // Menambahkan kolom stok_maksimum setelah kolom stok_minimum
            $table->integer('stok_maksimum')->default(100)->after('stok_minimum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Menghapus kolom jika database di-rollback
            $table->dropColumn('stok_maksimum');
        });
    }
};