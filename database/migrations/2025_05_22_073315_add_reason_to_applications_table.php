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
            $table->string('gender')->nullable();
            $table->string('application_reason')->nullable();
            $table->string('acceptance')->default('pending')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('application_reason');
            $table->string('acceptance')->nullable()->default(null)->change();
        });
    }
};
