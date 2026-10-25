<?php

namespace OurGym\Workout\Application;

use DateTimeImmutable;
use OurGym\Workout\Domain\Duration;
use OurGym\Workout\Domain\Exercise;
use OurGym\Workout\Domain\ExerciseSet;
use OurGym\Workout\Domain\Repetitions;
use OurGym\Workout\Domain\Title;
use OurGym\Workout\Domain\Weight;
use OurGym\Workout\Domain\Workout;
use OurGym\Workout\Domain\WorkoutDate;
use OurGym\Workout\Domain\WorkoutId;
use OurGym\Workout\Domain\WorkoutRepository;

final readonly class SaveWorkout
{
    public function __construct(private WorkoutRepository $repository) {}

    /**
     * @param  array{title: string, date: string, duration_minutes: int, exercises: list<array{title: string, sets: list<array{repetitions: int, weight: float}>}>}  $data
     */
    public function execute(array $data): Workout
    {
        $workout = new Workout(
            WorkoutId::generate(),
            new Title($data['title']),
            new WorkoutDate(new DateTimeImmutable($data['date'])),
            new Duration($data['duration_minutes']),
            ...array_map($this->createExercise(...), $data['exercises']),
        );

        $this->repository->save($workout);

        return $workout;
    }

    /**
     * @param  array{title: string, sets: list<array{repetitions: int, weight: float}>}  $exercise
     */
    private function createExercise(array $exercise): Exercise
    {
        return new Exercise(
            new Title($exercise['title']),
            ...array_map($this->createSet(...), $exercise['sets']),
        );
    }

    /**
     * @param  array{repetitions: int, weight: float}  $set
     */
    private function createSet(array $set): ExerciseSet
    {
        return new ExerciseSet(new Repetitions($set['repetitions']), new Weight($set['weight']));
    }
}
