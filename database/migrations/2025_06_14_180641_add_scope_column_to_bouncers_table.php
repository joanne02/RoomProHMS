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
        Schema::table('roles', function (Blueprint $table) {
            if (!Schema::hasColumn('roles', 'scope')) {
                $table->unsignedBigInteger('scope')->nullable()->index();
            }
        });

        Schema::table('assigned_roles', function (Blueprint $table) {
            if (!Schema::hasColumn('assigned_roles', 'scope')) {
                $table->unsignedBigInteger('scope')->nullable()->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('scope');
        });

        Schema::table('assigned_roles', function (Blueprint $table) {
            $table->dropColumn('scope');
        });
    }
};
