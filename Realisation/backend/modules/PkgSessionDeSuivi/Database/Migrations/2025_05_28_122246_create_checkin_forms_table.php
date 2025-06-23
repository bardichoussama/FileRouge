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
        Schema::create('checkin_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date'); 
            $table->date('end_date');  
            $table->boolean('is_active')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkin_forms');
    }
};
