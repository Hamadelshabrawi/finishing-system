<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('total_stock')->default(0);
            $table->decimal('current_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->integer('total_quantity')->default(0);
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['total_stock', 'current_cost', 'total_cost', 'total_quantity']);
        });
    }
};
