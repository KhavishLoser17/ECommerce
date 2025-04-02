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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->string('course_code', 20)->nullable();
            $table->string('course_name')->nullable();
            $table->string('class_group')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('schedule_type');
            $table->date('date');
            $table->date('end_date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location');
            $table->string('recurrence')->default('none');
            $table->string('days_of_week')->nullable();
            $table->date('recurrence_end')->nullable();
            $table->foreignId('master_schedule_id')->nullable()->constrained('schedules')->onDelete('cascade');
            $table->timestamps();
            // Indexes for performance
            $table->index(['teacher_id', 'date', 'start_time']);
            $table->index(['master_schedule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
