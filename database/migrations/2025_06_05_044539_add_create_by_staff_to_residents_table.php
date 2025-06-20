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
        Schema::table('residents', function (Blueprint $table) {
            // 1. Remove columns
            $table->dropColumn(['room_name', 'semester_year']);

            // 2. Make FK nullable
            $table->foreignId('application_id')->nullable()->change();

            // 3. Add new columns
            $table->boolean('create_by_staff')->default(false);
            $table->unsignedBigInteger('created_by_id')->nullable();

            // 4. Add foreign key constraint
            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->string('room_name')->nullable();
            $table->string('semester_year')->nullable();

            $table->foreignId('application_id')->nullable(false)->change();

            $table->dropForeign(['created_by_id']);
            $table->dropColumn(['create_by_staff', 'created_by_id']);
        });
    }
};
