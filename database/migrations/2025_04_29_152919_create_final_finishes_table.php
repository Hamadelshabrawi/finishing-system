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
        Schema::create('final_finishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->unique();
            $table->text('internal_paint')->nullable(); // دهانات داخلية
            $table->text('electrostatic')->nullable();  // الكتروستاتيك
            $table->text('pvd')->nullable();            // PVD
            $table->text('polishing')->nullable();      // فرش تلميع
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_finishes');
    }
};
