<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('item_consumption_logs', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->decimal('unit_cost', 10, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('item_consumption_logs', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'project_name', 'notes', 'unit_cost', 'total_cost']);
        });
    }
};
