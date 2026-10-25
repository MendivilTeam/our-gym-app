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

    public static function fromString(string $date): self
    {
        $parsedDate = DateTimeImmutable::createFromFormat('!Y-m-d', $date);

        if ($parsedDate === false || $parsedDate->format('Y-m-d') !== $date) {
            throw InvalidWorkout::invalidDate();
        }

        return new self($parsedDate);
    }

    private function validate(): void
    {
        if ($this->value > new DateTimeImmutable('today')) {
            throw InvalidWorkout::futureDate();
        }
    }
}
