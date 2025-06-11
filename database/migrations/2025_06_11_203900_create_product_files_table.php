<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name');
            $table->string('path');
            $table->string('type'); // image, document, etc.
            $table->string('extension');
            $table->string('original_name');
            $table->integer('size'); // in bytes
            $table->string('description')->nullable();
            $table->enum('phase', ['initial', 'technical', 'final'])->default('initial');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_files');
    }
};
