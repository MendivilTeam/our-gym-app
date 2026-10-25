<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SaveWorkoutRequest extends FormRequest
{
    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'exercises' => ['required', 'list', 'min:1', 'max:50'],
            'exercises.*.title' => ['required', 'string', 'max:255'],
            'exercises.*.sets' => ['required', 'list', 'min:1', 'max:50'],
            'exercises.*.sets.*.repetitions' => ['required', 'integer', 'min:1', 'max:1000'],
            'exercises.*.sets.*.weight' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:9999.99'],
        ];
    }

    /**
     * @return array{title: string, date: string, duration_minutes: int, exercises: list<array{title: string, sets: list<array{repetitions: int, weight: float}>}>}
     */
    public function workoutData(): array
    {
        /** @var array{title: string, date: string, duration_minutes: int, exercises: list<array{title: string, sets: list<array{repetitions: int, weight: float}>}>} $data */
        $data = $this->validated();

        return $data;
    }
}
