<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ai_insights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_checkin_id');
            $table->text('insight_text');
            $table->string('type');
            $table->timestamps(); // Add this - your repository uses created_at
            
            // Add foreign key constraint
            $table->foreign('student_checkin_id')
                  ->references('id')
                  ->on('student_checkins')
                  ->onDelete('cascade');
            
            // Add index for better performance
            $table->index('student_checkin_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_insights');
    }
};