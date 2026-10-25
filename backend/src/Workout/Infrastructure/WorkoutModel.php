<?php

namespace OurGym\Workout\Infrastructure;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('workouts', keyType: 'string', incrementing: false)]
#[Fillable(['id', 'title', 'date', 'duration_minutes'])]
final class WorkoutModel extends Model
{
    /** @return HasMany<WorkoutExerciseModel, $this> */
    public function exercises(): HasMany
    {
        return $this->hasMany(WorkoutExerciseModel::class, 'workout_id')->orderBy('position');
    }
}
