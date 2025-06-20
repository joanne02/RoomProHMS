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
       Schema::create('allocation_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('application_sessions')->onDelete('cascade');
            $table->unsignedInteger('chunk_number'); // ✅ required if you're tracking chunks
            $table->boolean('is_running')->default(false);
            $table->boolean('is_confirmed')->default(false);
            $table->float('overall_match_percentage')->nullable();
            $table->string('message')->nullable();
            $table->timestamps();

            // ✅ This should appear only once
            $table->unique(['session_id', 'chunk_number']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocation_statuses');
    }
};
