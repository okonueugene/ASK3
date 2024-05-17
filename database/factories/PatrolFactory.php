<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patrol>
 */
class PatrolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Patrol::class;

    public function definition(): array
    {
        $time = fake()->time();
        //ensure that the start time is before the end time
        $start = \Carbon\Carbon::parse($time);
        $end = \Carbon\Carbon::parse($time)->addHours(1);

        return [
            'site_id' => fake()->randomElement(\App\Models\Site::pluck('id')->toArray()),
            'name' => fake()->name(),
            'guard_id' => fake()->randomElement(\App\Models\Guard::pluck('id')->toArray()),
            'company_id' => fake()->randomElement(\App\Models\Company::pluck('id')->toArray()),
            'start' => $start,
            'end' => $end,
            'type' => fake()->randomElement(['scheduled', 'unscheduled']),
        ];
    }
}
