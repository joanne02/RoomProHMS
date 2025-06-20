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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('student_id')->nullable();
            $table->foreignId('session_id')->constrained('application_sessions')->onDelete('cascade');
            $table->string('faculty')->nullable();
            $table->string('program')->nullable();
            $table->text('address')->nullable();
            $table->string('year_of_study')->nullable();
            $table->string('contact_no')->nullable();
            $table->json('preferred_room_feature')->nullable();
            $table->string('application_status')->default('pending');
            $table->string('acceptance')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->string('acceptance_reject_reason')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
