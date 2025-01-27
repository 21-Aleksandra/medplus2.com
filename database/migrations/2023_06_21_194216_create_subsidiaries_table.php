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
        Schema::create('subsidiaries', function (Blueprint $table) {
            $table->id();
            $table->string('naming');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->string('email')->unique();
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('set null');
            

        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsidiaries');
    }
};
