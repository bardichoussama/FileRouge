<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('apprenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('groupe_id')->nullable()->constrained('groupes')->nullOnDelete();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('apprenants');
    }
}; 