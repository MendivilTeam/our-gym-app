<?php

namespace Tests\Unit\Workout\Domain;

use DateTimeImmutable;
use OurGym\Workout\Domain\InvalidWorkout;
use OurGym\Workout\Domain\WorkoutDate;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

final class WorkoutDateTest extends TestCase
{
    #[Test]
    public function givenTodayCreatesWorkoutDate(): void
    {
        $today = new DateTimeImmutable('today');

        $this->assertEquals($today, (new WorkoutDate($today))->value);
    }

    #[Test]
    public function givenDateWithTimeKeepsOnlyTheDay(): void
    {
        $date = new WorkoutDate(new DateTimeImmutable('2026-01-15 18:30'));

        $this->assertEquals(new DateTimeImmutable('2026-01-15'), $date->value);
    }

    #[Test]
    public function givenTomorrowThrowsInvalidWorkout(): void
    {
        $this->expectException(InvalidWorkout::class);

        new WorkoutDate(new DateTimeImmutable('tomorrow'));
    }

    #[Test]
    public function givenValidStringCreatesWorkoutDate(): void
    {
        $this->assertEquals(new DateTimeImmutable('2026-01-15'), WorkoutDate::fromString('2026-01-15')->value);
    }

    #[Test]
    #[TestWith(['2026-02-30'])]
    #[TestWith(['tomorrow'])]
    #[TestWith(['not-a-date'])]
    public function givenInvalidStringThrowsInvalidWorkout(string $date): void
    {
        $this->expectException(InvalidWorkout::class);

        WorkoutDate::fromString($date);
    }
}
