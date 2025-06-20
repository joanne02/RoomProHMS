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
        Schema::table('visitations', function (Blueprint $table) {
            // $table->string('token', 32)->unique()->after('id')->nullable();
            $table->string('other_purpose')->nullable()->after('purpose');
            $table->renameColumn('remark', 'description');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitations', function (Blueprint $table) {
            // $table->dropColumn('token');
            $table->dropColumn('other_purpose');
            $table->renameColumn('description', 'remark');
        });
    }
};
