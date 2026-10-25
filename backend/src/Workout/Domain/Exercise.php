<?php

namespace OurGym\Workout\Domain;

final readonly class Exercise
{
    /** @var list<ExerciseSet> */
    public array $sets;

    public function __construct(
        public Title $title,
        ExerciseSet ...$sets,
    ) {
        $this->sets = array_values($sets);
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->sets === []) {
            throw InvalidWorkout::exerciseWithoutSets();
        }
    }
}
