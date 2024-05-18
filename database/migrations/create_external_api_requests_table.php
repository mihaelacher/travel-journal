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
        Schema::create('external_api_requests', function (Blueprint $table) {
            $table->id()->autoIncrement()->unsigned();
            $table->string('request_body')->nullable();
            $table->string('request_response_code')->nullable();
            $table->json('request_response_body')->nullable();
            $table->string('request_endpoint');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->bigInteger('created_by')->unsigned();

            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_api_requests');
    }
};
