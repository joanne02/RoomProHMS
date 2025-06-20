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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('allocated_room_type')->nullable(); // Add the allocated_room_type column
            $table->decimal('allocation_match_percentage', 5, 2)->nullable(); // Add the allocation_match_percentage column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['allocated_room_type', 'allocation_match_percentage']); // Remove both columns if rolling back
        });
    }
};
