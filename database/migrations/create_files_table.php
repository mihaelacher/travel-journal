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
        Schema::create('files', function (Blueprint $table) {
            $table->id()->autoIncrement()->unsigned();
            $table->string('original_name');
            $table->string('system_name');
            $table->string('path');
            $table->tinyInteger('file_type_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at');

            $table->foreign('file_type_id')->references('id')->on('file_types');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
