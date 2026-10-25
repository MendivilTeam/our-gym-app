<?php

namespace OurGym\Workout\Domain;

final readonly class Title
{
    public function __construct(public string $value)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (trim($this->value) === '') {
            throw InvalidWorkout::emptyTitle();
        }
    }
}
