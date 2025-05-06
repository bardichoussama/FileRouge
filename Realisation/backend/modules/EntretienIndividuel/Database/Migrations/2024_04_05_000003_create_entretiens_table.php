<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entretiens', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->dateTime('date_heure');
            $table->integer('duree_minutes');
            $table->foreignId('responsable_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('groupe_id')->constrained('groupes')->onDelete('cascade');
            $table->foreignId('formulaire_id')->nullable()->constrained('formulaires')->onDelete('set null');
            $table->enum('statut', ['planifié', 'en_cours', 'terminé', 'annulé'])->default('planifié');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entretiens');
    }
}; 