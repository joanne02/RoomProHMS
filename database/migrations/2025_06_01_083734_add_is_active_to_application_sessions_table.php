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
        Schema::table('application_sessions', function (Blueprint $table) {
            $table->dateTime('acceptance_start_date')->nullable();
            $table->dateTime('acceptance_end_date')->nullable();
            $table->boolean('is_active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_sessions', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('acceptance_start_date');
            $table->dropColumn('acceptance_end_date');
        });
    }
};
