<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Create abilities table
        Schema::create('abilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();
            $table->nullableMorphs('entity');
            $table->boolean('only_owned')->default(false);
            $table->boolean('options')->nullable();
            $table->string('scope')->nullable(); // Add the scope column
            $table->timestamps();
        });

        // Create roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();
            $table->timestamps();
        });

        // Create permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('entity');
            $table->unsignedBigInteger('ability_id'); // Reference to abilities table
            $table->nullableMorphs('restricted_to');
            $table->boolean('forbidden')->default(false); // Add the forbidden column
            $table->timestamps();

            // Foreign key constraint to abilities table
            $table->foreign('ability_id')->references('id')->on('abilities')->onDelete('cascade');
        });

        // Create assigned_roles table
        Schema::create('assigned_roles', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('entity');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assigned_roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('abilities');
    }
};
