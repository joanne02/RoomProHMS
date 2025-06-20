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
        Schema::create('application_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_name')->unique()->nullable();
            $table->integer('semester')->nullable();
            $table->string('year')->nullable();
            $table->string('application_batch')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('application_start_date')->nullable();
            $table->dateTime('application_end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_sessions');
    }
};
