<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OurGym\Workout\Domain\WorkoutRepository;
use OurGym\Workout\Infrastructure\EloquentWorkoutRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WorkoutRepository::class, EloquentWorkoutRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
