<?php

namespace OurGym\Workout\Domain;

use Ramsey\Uuid\Uuid;

final readonly class WorkoutId
{
    public function __construct(public string $value)
    {
        $this->validate();
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid7()->toString());
    }

    private function validate(): void
    {
        if (! Uuid::isValid($this->value)) {
            throw InvalidWorkout::invalidId();
        }
    }
}
