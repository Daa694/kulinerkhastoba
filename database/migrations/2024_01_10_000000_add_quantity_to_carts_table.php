<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('carts')) {
            Schema::create('carts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('kuliner_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        Schema::table('carts', function (Blueprint $table) {
            if (!Schema::hasColumn('carts', 'quantity')) {
                $table->integer('quantity')->default(1)->after('kuliner_id');
            }
            if (!Schema::hasColumn('carts', 'is_checked_out')) {
                $table->boolean('is_checked_out')->default(false)->after('quantity');
            }
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'is_checked_out']);
        });
        Schema::dropIfExists('carts');
    }
};