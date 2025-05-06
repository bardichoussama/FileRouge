<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reponse_formulaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulaire_id')->constrained('formulaires')->onDelete('cascade');
            $table->foreignId('apprenant_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('date_soumission');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reponse_formulaires');
    }
}; 