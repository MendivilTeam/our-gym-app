<?php

namespace Tests\Unit\Workout\Domain;

use OurGym\Workout\Domain\InvalidWorkout;
use OurGym\Workout\Domain\Repetitions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class RepetitionsTest extends TestCase
{
    #[Test]
    public function givenPositiveValueCreatesRepetitions(): void
    {
        $this->assertSame(10, (new Repetitions(10))->value);
    }

    #[Test]
    public function givenZeroThrowsInvalidWorkout(): void
    {
        $this->expectException(InvalidWorkout::class);

        new Repetitions(0);
    }
}
