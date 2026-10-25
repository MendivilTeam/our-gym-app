<?php

namespace Tests\Integration;

use Illuminate\Support\Facades\Route;
use OurGym\Workout\Domain\InvalidWorkout;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Tests\TestCase;

final class ErrorHandlingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/api/invalid-workout', fn () => throw InvalidWorkout::emptyTitle());
        Route::get('/api/unexpected-error', fn () => throw new RuntimeException('database password leaked'));
    }

    #[Test]
    public function givenInvalidWorkoutReturns422WithItsMessage(): void
    {
        $this->getJson('/api/invalid-workout')
            ->assertUnprocessable()
            ->assertExactJson(['message' => 'Title cannot be empty.']);
    }

    #[Test]
    public function givenUnexpectedErrorReturns500WithoutDetails(): void
    {
        config(['app.debug' => false]);

        $this->getJson('/api/unexpected-error')
            ->assertInternalServerError()
            ->assertExactJson(['message' => 'Server Error'])
            ->assertDontSee('database password leaked');
    }

    #[Test]
    public function givenUnknownApiRouteReturns404AsJson(): void
    {
        $this->getJson('/api/unknown')
            ->assertNotFound()
            ->assertJsonStructure(['message']);
    }
}
