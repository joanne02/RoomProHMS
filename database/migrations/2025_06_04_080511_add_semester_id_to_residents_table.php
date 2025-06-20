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
        Schema::table('residents', function (Blueprint $table) {
            $table->unsignedBigInteger('semester_id')->nullable();

            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters')
                ->onDelete('set null'); // or 'cascade', depending on your needs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropForeign(['semester_id']);
            $table->dropColumn('semester_id');
        });
    }
};
