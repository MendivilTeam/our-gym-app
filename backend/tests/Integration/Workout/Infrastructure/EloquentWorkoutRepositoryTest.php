<?php

namespace Tests\Integration\Workout\Infrastructure;

use DateTimeImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OurGym\Workout\Domain\Duration;
use OurGym\Workout\Domain\Exercise;
use OurGym\Workout\Domain\ExerciseSet;
use OurGym\Workout\Domain\Repetitions;
use OurGym\Workout\Domain\Title;
use OurGym\Workout\Domain\Weight;
use OurGym\Workout\Domain\Workout;
use OurGym\Workout\Domain\WorkoutDate;
use OurGym\Workout\Domain\WorkoutId;
use OurGym\Workout\Infrastructure\EloquentWorkoutRepository;
use OurGym\Workout\Infrastructure\WorkoutModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class EloquentWorkoutRepositoryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function givenWorkoutSavesItWithExercisesAndSetsInOrder(): void
    {
        $workout = $this->workout(
            new Exercise(new Title('Bench press'), $this->set(10, 60), $this->set(8, 62.5)),
            new Exercise(new Title('Shoulder press'), $this->set(12, 20)),
        );

        (new EloquentWorkoutRepository)->save($workout);

        $saved = WorkoutModel::with('exercises.sets')->findOrFail($workout->id->value);
        $this->assertSame('Push day', $saved->title);
        $this->assertSame(['Bench press', 'Shoulder press'], $saved->exercises->pluck('title')->all());
        $this->assertSame(['60.00', '62.50'], $saved->exercises->firstOrFail()->sets->pluck('weight')->all());
    }

    #[Test]
    public function givenFailureWhileSavingSetsSavesNothing(): void
    {
        $workout = $this->workout(new Exercise(new Title('Leg press'), $this->set(10, 10000)));

        $this->assertThrows(fn () => (new EloquentWorkoutRepository)->save($workout), QueryException::class);

        $this->assertDatabaseEmpty('workouts');
        $this->assertDatabaseEmpty('workout_exercises');
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

    private function set(int $repetitions, float $weight): ExerciseSet
    {
        return new ExerciseSet(new Repetitions($repetitions), new Weight($weight));
    }
}
