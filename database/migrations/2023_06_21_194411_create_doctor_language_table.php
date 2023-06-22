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
        Schema::create('doctor_language', function (Blueprint $table) {
          $table->unsignedBigInteger('doctor_id')->nullable();
          $table->unsignedBigInteger('language_id')->nullable();
    

          $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
          $table->foreign('language_id')->references('id')->on('languages')->onDelete('set null');

          $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_language');
    }
};
