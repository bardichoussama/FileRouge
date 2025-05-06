<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reponse_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reponse_question_id')->constrained('reponse_questions')->onDelete('cascade');
            $table->foreignId('option_reponse_id')->constrained('option_reponses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reponse_options');
    }
}; 