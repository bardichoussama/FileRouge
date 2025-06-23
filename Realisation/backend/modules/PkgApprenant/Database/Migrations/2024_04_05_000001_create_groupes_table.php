<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('groupes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('promotion_id');
            $table->timestamps();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('groupes');
    }
}; 