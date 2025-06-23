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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            
            $table->string('name')->nullable(); // e.g., "2024-2025 Academic Year"
            $table->text('description')->nullable();
            $table->date('start_date'); // Actual start date of the promotion
            $table->date('end_date');   // Actual end date of the promotion
            $table->boolean('is_active')->default(true); // To manually enable/disable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};

