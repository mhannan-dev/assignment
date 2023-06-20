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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('class_model_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('subject_id');
            $table->timestamp('assign_date');
            $table->timestamp('submission_date');
            $table->text('description');
            $table->string('assigned_by');
            $table->string('status')->default('pending')->comment('pending, completed, or overdue');
            $table->unsignedBigInteger('marks');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_model_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
