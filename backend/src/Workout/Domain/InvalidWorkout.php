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

    public static function invalidId(): self
    {
        return new self('Workout id must be a valid UUID.');
    }

    public static function emptyTitle(): self
    {
        return new self('Title cannot be empty.');
    }

    public static function futureDate(): self
    {
        return new self('Workout date cannot be in the future.');
    }

    public static function nonPositiveDuration(): self
    {
        return new self('Duration must be greater than 0 minutes.');
    }

    public static function exerciseWithoutSets(): self
    {
        return new self('An exercise needs at least one set.');
    }

    public static function workoutWithoutExercises(): self
    {
        return new self('A workout needs at least one exercise.');
    }
}
