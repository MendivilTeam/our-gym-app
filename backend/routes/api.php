<?php

use App\Http\Controllers\SaveWorkoutController;
use Illuminate\Support\Facades\Route;

Route::post('/workouts', SaveWorkoutController::class);
