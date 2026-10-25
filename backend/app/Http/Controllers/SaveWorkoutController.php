<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveWorkoutRequest;
use App\Http\Resources\WorkoutResource;
use Illuminate\Http\JsonResponse;
use OurGym\Workout\Application\SaveWorkout;

final class SaveWorkoutController extends Controller
{
    public function __invoke(SaveWorkoutRequest $request, SaveWorkout $saveWorkout): JsonResponse
    {
        $workout = $saveWorkout->execute($request->workoutData());

        return WorkoutResource::make($workout)->response()->setStatusCode(201);
    }
}
