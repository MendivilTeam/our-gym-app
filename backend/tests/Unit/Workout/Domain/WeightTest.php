<?php

namespace Tests\Unit\Workout\Domain;

use OurGym\Workout\Domain\InvalidWorkout;
use OurGym\Workout\Domain\Weight;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class WeightTest extends TestCase
{
    #[Test]
    public function givenZeroCreatesWeight(): void
    {
        $this->assertSame(0.0, (new Weight(0))->kilograms);
    }

    #[Test]
    public function givenTwoDecimalsCreatesWeight(): void
    {
        $this->assertSame(22.55, (new Weight(22.55))->kilograms);
    }

    #[Test]
    public function givenNegativeValueThrowsInvalidWorkout(): void
    {
        $this->expectException(InvalidWorkout::class);

        new Weight(-0.01);
    }

    #[Test]
    public function givenMoreThanTwoDecimalsThrowsInvalidWorkout(): void
    {
        $this->expectException(InvalidWorkout::class);

        new Weight(22.555);
    }
}
