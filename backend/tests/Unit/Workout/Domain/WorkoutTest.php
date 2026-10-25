<?php

namespace Tests\Unit\Workout\Domain;

use DateTimeImmutable;
use OurGym\Workout\Domain\Duration;
use OurGym\Workout\Domain\Exercise;
use OurGym\Workout\Domain\ExerciseSet;
use OurGym\Workout\Domain\InvalidWorkout;
use OurGym\Workout\Domain\Repetitions;
use OurGym\Workout\Domain\Title;
use OurGym\Workout\Domain\Weight;
use OurGym\Workout\Domain\Workout;
use OurGym\Workout\Domain\WorkoutDate;
use OurGym\Workout\Domain\WorkoutId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class WorkoutTest extends TestCase
{
    #[Test]
    public function givenExercisesKeepsTheirOrder(): void
    {
        $benchPress = $this->exercise('Bench press');
        $shoulderPress = $this->exercise('Shoulder press');

        $workout = $this->workout($benchPress, $shoulderPress);

        $this->assertSame([$benchPress, $shoulderPress], $workout->exercises);
    }

    #[Test]
    public function givenNoExercisesThrowsInvalidWorkout(): void
    {
        $this->expectException(InvalidWorkout::class);

        $this->workout();
    }

    private function workout(Exercise ...$exercises): Workout
    {
        return new Workout(
            WorkoutId::generate(),
            new Title('Push day'),
            new WorkoutDate(new DateTimeImmutable('today')),
            new Duration(60),
            ...$exercises,
        );
    }

    private function exercise(string $title): Exercise
    {
        return new Exercise(new Title($title), new ExerciseSet(new Repetitions(10), new Weight(60)));
    }
}
