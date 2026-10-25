<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OurGym\Workout\Domain\Exercise;
use OurGym\Workout\Domain\ExerciseSet;
use OurGym\Workout\Domain\Workout;

final class WorkoutResource extends JsonResource
{
    public function __construct(Workout $workout)
    {
        parent::__construct($workout);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Workout $workout */
        $workout = $this->resource;

        return [
            'id' => $workout->id->value,
            'title' => $workout->title->value,
            'date' => $workout->date->value->format('Y-m-d'),
            'duration_minutes' => $workout->duration->minutes,
            'exercises' => array_map(fn (Exercise $exercise) => [
                'title' => $exercise->title->value,
                'sets' => array_map(fn (ExerciseSet $set) => [
                    'repetitions' => $set->repetitions->value,
                    'weight' => $set->weight->kilograms,
                ], $exercise->sets),
            ], $workout->exercises),
        ];
    }
}
