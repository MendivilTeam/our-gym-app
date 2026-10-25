<?php

namespace OurGym\Workout\Domain;

use DateTimeImmutable;

final readonly class WorkoutDate
{
    public DateTimeImmutable $value;

    public function __construct(DateTimeImmutable $value)
    {
        $this->value = $value->setTime(0, 0);
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->value > new DateTimeImmutable('today')) {
            throw InvalidWorkout::futureDate();
        }
    }
}
