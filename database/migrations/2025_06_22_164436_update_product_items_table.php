<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_items', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('product_items', 'unit_price')) {
                $table->dropColumn('unit_price');
            }
            if (Schema::hasColumn('product_items', 'total_price')) {
                $table->dropColumn('total_price');
            }

            // Add new columns
            $table->decimal('unit_cost', 10, 2)->after('item_id');
            $table->decimal('cost', 10, 2)->after('unit_cost');
            $table->timestamp('consumed_at')->nullable()->after('cost');
        });
    }

    public function down()
    {
        Schema::table('product_items', function (Blueprint $table) {
            $table->dropColumn(['unit_cost', 'cost', 'consumed_at']);
            $table->decimal('unit_price', 10, 2)->after('item_id');
            $table->decimal('total_price', 10, 2)->after('unit_price');
        });
    }
};
