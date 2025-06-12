<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */    public function up(): void
    {
        Schema::table('kuliners', function (Blueprint $table) {
            // Drop kolom gambar lama jika ada
            if (Schema::hasColumn('kuliners', 'gambar')) {
                $table->dropColumn('gambar');
            }
            
            // Tambah kolom gambar_kuliner jika belum ada
            if (!Schema::hasColumn('kuliners', 'gambar_kuliner')) {
                $table->string('gambar_kuliner')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuliners', function (Blueprint $table) {
            //
        });
    }
};
