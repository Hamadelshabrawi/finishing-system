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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->text('address')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('commercial_registration_number')->nullable();
            $table->enum('type', ['individual', 'company'])->default('individual');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes(); // For archiving clients instead of permanent deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
