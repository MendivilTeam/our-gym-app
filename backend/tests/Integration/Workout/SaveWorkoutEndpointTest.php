<?php

namespace Tests\Integration\Workout;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SaveWorkoutEndpointTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function givenValidWorkoutReturns201WithTheSavedWorkout(): void
    {
        $response = $this->postJson('/api/workouts', $this->workout());

        $response->assertCreated()
            ->assertJsonPath('data.title', 'Push day')
            ->assertJsonPath('data.date', '2026-01-15')
            ->assertJsonPath('data.duration_minutes', 60)
            ->assertJsonPath('data.exercises.0.title', 'Bench press')
            ->assertJsonPath('data.exercises.0.sets.1', ['repetitions' => 8, 'weight' => 62.5])
            ->assertJsonPath('data.exercises.1.title', 'Shoulder press');
        $this->assertDatabaseHas('workouts', ['id' => $response->json('data.id'), 'title' => 'Push day']);
    }

    #[Test]
    public function givenInvalidSetReturns422WithFieldErrors(): void
    {
        $workout = $this->workout();
        $workout['exercises'][0]['sets'][0]['repetitions'] = 0;

        $this->postJson('/api/workouts', $workout)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['exercises.0.sets.0.repetitions']);
        $this->assertDatabaseEmpty('workouts');
    }

    #[Test]
    public function givenFutureDateReturns422WithFieldErrors(): void
    {
        $workout = $this->workout();
        $workout['date'] = now()->addDay()->format('Y-m-d');

        $this->postJson('/api/workouts', $workout)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['date']);
    }

    /**
     * @return array{title: string, date: string, duration_minutes: int, exercises: list<array{title: string, sets: list<array{repetitions: int, weight: float}>}>}
     */
    private function workout(): array
    {
        return [
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
        ];
    }
}
