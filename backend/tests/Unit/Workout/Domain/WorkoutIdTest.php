<?php

namespace Tests\Unit\Workout\Domain;

use OurGym\Workout\Domain\InvalidWorkout;
use OurGym\Workout\Domain\WorkoutId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class WorkoutIdTest extends TestCase
{
    #[Test]
    public function givenGeneratedIdReturnsValidUuid(): void
    {
        $id = WorkoutId::generate();

        $this->assertSame($id->value, (new WorkoutId($id->value))->value);
    }

    #[Test]
    public function givenInvalidUuidThrowsInvalidWorkout(): void
    {
        $this->expectException(InvalidWorkout::class);

        new WorkoutId('not-a-uuid');
    }
}
