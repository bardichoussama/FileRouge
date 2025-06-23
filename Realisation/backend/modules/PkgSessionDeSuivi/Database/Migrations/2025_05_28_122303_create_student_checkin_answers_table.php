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
        Schema::create('student_checkin_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkin_id');
            $table->unsignedBigInteger('question_id');
            $table->text('answer_text');
            $table->timestamps();

            $table->foreign('checkin_id')->references('id')->on('student_checkins')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_checkin_answers');
    }
};
