<?php

namespace OurGym\Workout\Infrastructure;

use Illuminate\Support\Facades\DB;
use OurGym\Workout\Domain\Workout;
use OurGym\Workout\Domain\WorkoutRepository;

final readonly class EloquentWorkoutRepository implements WorkoutRepository
{
    public function save(Workout $workout): void
    {
        DB::transaction(function () use ($workout): void {
            $workoutModel = WorkoutModel::create([
                'id' => $workout->id->value,
                'title' => $workout->title->value,
                'date' => $workout->date->value->format('Y-m-d'),
                'duration_minutes' => $workout->duration->minutes,
            ]);

            foreach ($workout->exercises as $exercisePosition => $exercise) {
                $exerciseModel = $workoutModel->exercises()->create([
                    'position' => $exercisePosition,
                    'title' => $exercise->title->value,
                ]);

                foreach ($exercise->sets as $setPosition => $set) {
                    $exerciseModel->sets()->create([
                        'position' => $setPosition,
                        'repetitions' => $set->repetitions->value,
                        'weight' => $set->weight->kilograms,
                    ]);
                }
            }
        });
    }
}
