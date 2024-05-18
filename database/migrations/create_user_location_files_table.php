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
        Schema::create('user_location_files', function (Blueprint $table) {
            $table->id()->autoIncrement()->unsigned();
            $table->bigInteger('user_location_id')->unsigned();
            $table->bigInteger('file_id')->unsigned();

            $table->foreign('user_location_id')->references('id')->on('user_locations');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_location_files');
    }
};
