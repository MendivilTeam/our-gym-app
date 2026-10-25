<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->date('date');
            $table->unsignedSmallInteger('duration_minutes');
            $table->timestamps();
        });

        Schema::create('workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('workout_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position');
            $table->string('title');
            $table->unique(['workout_id', 'position']);
        });

        Schema::create('exercise_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_exercise_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position');
            $table->unsignedSmallInteger('repetitions');
            $table->decimal('weight', 6, 2);
            $table->unique(['workout_exercise_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercise_sets');
        Schema::dropIfExists('workout_exercises');
        Schema::dropIfExists('workouts');
    }
};
