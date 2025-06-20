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
        Schema::table('complaints', function (Blueprint $table) {
            $table->renameColumn('student_id', 'identify_number');
            $table->string('name')->nullable()->after('student_id');
            $table->string('category')->nullable()->after('type');
            $table->string('room_name')->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->renameColumn('identify_number', 'student_id');
            $table->dropColumn('name');
            $table->dropColumn('category');
            $table->dropColumn('room_name');
        });
    }
};
