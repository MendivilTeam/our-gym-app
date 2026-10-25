<?php

namespace Tests\Unit\Workout\Domain;

use OurGym\Workout\Domain\Exercise;
use OurGym\Workout\Domain\ExerciseSet;
use OurGym\Workout\Domain\InvalidWorkout;
use OurGym\Workout\Domain\Repetitions;
use OurGym\Workout\Domain\Title;
use OurGym\Workout\Domain\Weight;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ExerciseTest extends TestCase
{
    #[Test]
    public function givenSetsKeepsTheirOrder(): void
    {
        $first = new ExerciseSet(new Repetitions(10), new Weight(60));
        $second = new ExerciseSet(new Repetitions(8), new Weight(65));

        $exercise = new Exercise(new Title('Bench press'), $first, $second);

        $this->assertSame([$first, $second], $exercise->sets);
    }

    #[Test]
    public function givenNoSetsThrowsInvalidWorkout(): void
    {
        $this->expectException(InvalidWorkout::class);

        new Exercise(new Title('Bench press'));
    }
}
