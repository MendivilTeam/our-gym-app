<?php

namespace OurGym\Workout\Domain;

final readonly class Duration
{
    public function __construct(public int $minutes)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->minutes <= 0) {
            throw InvalidWorkout::nonPositiveDuration();
        }
    }
}
