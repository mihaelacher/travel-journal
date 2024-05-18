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
        Schema::create('share_locations_users', function (Blueprint $table) {
            $table->id()->autoIncrement()->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('share_locations_user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('share_locations_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('share_locations_users');
    }
};
