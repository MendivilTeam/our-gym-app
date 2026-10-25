<?php

namespace OurGym\Workout\Domain;

interface WorkoutRepository
{
    public function save(Workout $workout): void;
}
