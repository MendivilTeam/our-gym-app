<?php

namespace Tests\Unit\Workout\Domain;

use OurGym\Workout\Domain\Duration;
use OurGym\Workout\Domain\InvalidWorkout;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DurationTest extends TestCase
{
    #[Test]
    public function givenOneMinuteCreatesDuration(): void
    {
        $this->assertSame(1, (new Duration(1))->minutes);
    }

    #[Test]
    public function givenZeroMinutesThrowsInvalidWorkout(): void
    {
        $this->expectException(InvalidWorkout::class);

        new Duration(0);
    }
}
