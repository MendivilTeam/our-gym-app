<?php

namespace OurGym\Workout\Infrastructure;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('workout_exercises', timestamps: false)]
#[Fillable(['position', 'title'])]
final class WorkoutExerciseModel extends Model
{
    /** @return HasMany<ExerciseSetModel, $this> */
    public function sets(): HasMany
    {
        return $this->hasMany(ExerciseSetModel::class, 'workout_exercise_id')->orderBy('position');
    }
}
