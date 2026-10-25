<?php

namespace Tests\Unit\Workout\Application;

use DateTimeImmutable;
use OurGym\Workout\Application\SaveWorkout;
use OurGym\Workout\Domain\InvalidWorkout;
use OurGym\Workout\Domain\Workout;
use OurGym\Workout\Domain\WorkoutRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SaveWorkoutTest extends TestCase
{
    #[Test]
    public function givenValidDataSavesAndReturnsTheWorkout(): void
    {
        $repository = $this->createMock(WorkoutRepository::class);
        $savedWorkout = null;
        $repository->expects($this->once())
            ->method('save')
            ->willReturnCallback(function (Workout $workout) use (&$savedWorkout): void {
                $savedWorkout = $workout;
            });

        $workout = (new SaveWorkout($repository))->execute([
            'title' => 'Push day',
            'date' => '2026-01-15',
            'duration_minutes' => 60,
            'exercises' => [
                ['title' => 'Bench press', 'sets' => [
                    ['repetitions' => 10, 'weight' => 60.0],
                    ['repetitions' => 8, 'weight' => 62.5],
                ]],
                ['title' => 'Shoulder press', 'sets' => [
                    ['repetitions' => 12, 'weight' => 20.0],
                ]],
            ],
        ]);

        $this->assertSame($workout, $savedWorkout);
        $this->assertSame('Push day', $workout->title->value);
        $this->assertEquals(new DateTimeImmutable('2026-01-15'), $workout->date->value);
        $this->assertSame(60, $workout->duration->minutes);
        $this->assertSame('Bench press', $workout->exercises[0]->title->value);
        $this->assertSame('Shoulder press', $workout->exercises[1]->title->value);
        $this->assertSame(10, $workout->exercises[0]->sets[0]->repetitions->value);
        $this->assertSame(62.5, $workout->exercises[0]->sets[1]->weight->kilograms);
    }

    #[Test]
    public function givenInvalidDataThrowsInvalidWorkoutWithoutSaving(): void
    {
        $repository = $this->createMock(WorkoutRepository::class);
        $repository->expects($this->never())->method('save');

        $this->expectException(InvalidWorkout::class);

        (new SaveWorkout($repository))->execute([
            'title' => 'Push day',
            'date' => '2026-01-15',
            'duration_minutes' => 60,
            'exercises' => [
                ['title' => 'Bench press', 'sets' => [['repetitions' => 0, 'weight' => 60.0]]],
            ],
        ]);
    }
}
