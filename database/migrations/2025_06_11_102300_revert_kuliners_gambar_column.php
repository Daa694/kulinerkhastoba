<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevertKulinersGambarColumn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kuliners', function (Blueprint $table) {
            // Drop the gambar_kuliner column if it exists
            if (Schema::hasColumn('kuliners', 'gambar_kuliner')) {
                $table->dropColumn('gambar_kuliner');
            }
            
            // Add back the gambar column if it doesn't exist
            if (!Schema::hasColumn('kuliners', 'gambar')) {
                $table->string('gambar')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuliners', function (Blueprint $table) {
            if (Schema::hasColumn('kuliners', 'gambar')) {
                $table->dropColumn('gambar');
            }
            
            if (!Schema::hasColumn('kuliners', 'gambar_kuliner')) {
                $table->string('gambar_kuliner')->nullable();
            }
        });
    }
};
