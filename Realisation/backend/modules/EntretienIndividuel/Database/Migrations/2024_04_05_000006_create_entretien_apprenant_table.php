<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entretien_apprenant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entretien_id')->constrained('entretiens')->onDelete('cascade');
            $table->foreignId('apprenant_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['entretien_id', 'apprenant_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('entretien_apprenant');
    }
}; 