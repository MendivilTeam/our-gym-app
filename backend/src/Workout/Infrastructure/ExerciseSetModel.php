<?php

namespace OurGym\Workout\Infrastructure;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('exercise_sets', timestamps: false)]
#[Fillable(['position', 'repetitions', 'weight'])]
final class ExerciseSetModel extends Model {}
