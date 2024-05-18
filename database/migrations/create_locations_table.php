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
        Schema::create('locations', function (Blueprint $table) {
            $table->id()->autoIncrement()->unsigned();
            $table->string('name');
            $table->json('photo_references')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('vicinity')->nullable();

            $table->unique(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
