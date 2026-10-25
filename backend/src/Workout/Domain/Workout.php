<?php

namespace OurGym\Workout\Domain;

final readonly class Workout
{
    /** @var list<Exercise> */
    public array $exercises;

    public function __construct(
        public WorkoutId $id,
        public Title $title,
        public WorkoutDate $date,
        public Duration $duration,
        Exercise ...$exercises,
    ) {
        $this->exercises = array_values($exercises);
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->exercises === []) {
            throw InvalidWorkout::workoutWithoutExercises();
        }
    }
}
