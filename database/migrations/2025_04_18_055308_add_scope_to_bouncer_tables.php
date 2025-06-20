<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('abilities', function (Blueprint $table) {
            if (!Schema::hasColumn('abilities', 'scope')) {
                $table->unsignedBigInteger('scope')->nullable()->index();
            }
        });

        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'scope')) {
                $table->unsignedBigInteger('scope')->nullable()->index();
            }
        });

    }

    public function down()
    {
        Schema::table('abilities', function (Blueprint $table) {
            $table->dropColumn('scope');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('scope');
        });
    }
};
