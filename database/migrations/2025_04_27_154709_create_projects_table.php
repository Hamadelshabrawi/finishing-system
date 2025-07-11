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
            $table->date('date')->nullable();
            $table->string('contact_value')->nullable();
            $table->integer('execution_period')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_location')->nullable();
            $table->foreignId('client_id')->nullable()
            ->constrained('clients')
            ->onDelete('restrict');
            $table->text('description')->nullable();
            $table->enum('technical_approval', ['pending', 'approved', 'need_modify','dismissed'])->default('pending')->nullable();
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
