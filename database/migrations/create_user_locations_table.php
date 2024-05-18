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
        Schema::create('user_locations', function (Blueprint $table) {
            $table->id()->autoIncrement()->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('location_id')->unsigned();
            $table->json('photo_references');
            $table->date('visited_at');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->unique(['user_id', 'location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_locations');
    }
};
