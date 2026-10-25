<?php

namespace OurGym\Workout\Domain;

final readonly class Repetitions
{
    public function __construct(public int $value)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->value <= 0) {
            throw InvalidWorkout::nonPositiveRepetitions();
        }
    }
}
