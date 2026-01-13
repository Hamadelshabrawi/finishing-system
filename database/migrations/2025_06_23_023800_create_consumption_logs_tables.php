<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('item_consumption_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_purchase_id')->constrained('item_purchases')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->timestamps();
        });

        Schema::create('product_item_consumption_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_item_id')->constrained('product_items')->onDelete('cascade');
            $table->integer('total_quantity');
            $table->decimal('total_cost', 10, 2);
            $table->decimal('average_cost', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_item_consumption_logs');
        Schema::dropIfExists('item_consumption_logs');
    }
};
