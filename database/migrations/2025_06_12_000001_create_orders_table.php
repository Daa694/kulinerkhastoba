<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_id')->unique();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->decimal('total', 10, 2);
                $table->string('status')->default('pending');
                $table->string('payment_status')->default('pending');
                $table->string('snap_token')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
