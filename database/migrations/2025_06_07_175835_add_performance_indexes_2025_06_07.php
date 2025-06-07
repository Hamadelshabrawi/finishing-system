<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->index('client_id');
            $table->index('created_by');
            $table->index('delivery_date');
            $table->index('initial_approval');
            $table->index('technical_approval');
        });

        Schema::table('project_files', function (Blueprint $table) {
            $table->index('project_id');
            $table->index('phase');
            $table->index('uploaded_by');
        });

        Schema::table('item_purchases', function (Blueprint $table) {
            $table->index('item_id');
            $table->index('purchase_date');
            $table->index('remaining_quantity');
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->index('project_id');
            $table->index('item_id');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['client_id']);
            $table->dropIndex(['created_by']);
            $table->dropIndex(['delivery_date']);
            $table->dropIndex(['initial_approval']);
            $table->dropIndex(['technical_approval']);
        });

        Schema::table('project_files', function (Blueprint $table) {
            $table->dropIndex(['project_id']);
            $table->dropIndex(['phase']);
            $table->dropIndex(['uploaded_by']);
        });

        Schema::table('item_purchases', function (Blueprint $table) {
            $table->dropIndex(['item_id']);
            $table->dropIndex(['purchase_date']);
            $table->dropIndex(['remaining_quantity']);
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropIndex(['project_id']);
            $table->dropIndex(['item_id']);
        });
    }
}
