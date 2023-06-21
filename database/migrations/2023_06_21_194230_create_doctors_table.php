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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->unsignedBigInteger('profession_id');
            $table->unsignedBigInteger('subsidiary_id');

            $table->integer('phone');
            $table->timestamps();

            $table->foreign('profession_id')->references('id')->on('professions')->onDelete('cascade');
            $table->foreign('subsidiary_id')->references('id')->on('subsidiaries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
