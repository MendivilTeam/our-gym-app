<?php

namespace OurGym\Workout\Domain;

final readonly class Weight
{
    public function __construct(public float $kilograms)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->kilograms < 0 || round($this->kilograms, 2) !== $this->kilograms) {
            throw InvalidWorkout::invalidWeight();
        }
    }
}
