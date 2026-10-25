<?php

namespace OurGym\Workout\Domain;

final readonly class ExerciseSet
{
    public function __construct(
        public Repetitions $repetitions,
        public Weight $weight,
    ) {}
}
