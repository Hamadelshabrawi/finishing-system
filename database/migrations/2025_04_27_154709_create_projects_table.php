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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('item_name');
            $table->integer('quantity');
            $table->integer('execution_period');
            $table->date('delivery_date');
            $table->string('delivery_location');
            $table->foreignId('client_id')
            ->constrained('clients')
            ->onDelete('restrict');
            $table->string('panel_number');
            $table->text('description');
            $table->enum('initial_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('technical_approval', ['pending', 'approved', 'need_modify','dismissed'])->default('pending');
            $table->foreignId('created_by')->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
