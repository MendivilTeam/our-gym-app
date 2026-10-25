<?php

namespace OurGym\Workout\Domain;

use DomainException;

final class InvalidWorkout extends DomainException
{
    public static function nonPositiveRepetitions(): self
    {
        return new self('Repetitions must be greater than 0.');
    }

    public static function invalidWeight(): self
    {
        return new self('Weight must be 0 or more kilograms with up to 2 decimals.');
    }
}
