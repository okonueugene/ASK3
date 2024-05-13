<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident>
 */
class IncidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Incident::class;
    public function definition(): array
    {
        return [
            'site_id' => fake()->randomElement(\App\Models\Site::pluck('id')->toArray()),
            'guard_id' => fake()->randomElement(\App\Models\Guard::pluck('id')->toArray()),
            'company_id' => fake()->randomElement(\App\Models\Company::pluck('id')->toArray()),
            'incident_no' => fake()->unique()->randomNumber(5),
            'police_ref' => fake()->unique()->randomNumber(5),
            'details' => fake()->sentence(),
            'date' => fake()->dateTimeBetween('-1 years', 'now'),
            'time' => fake()->time(),
            'actions_taken' => fake()->sentence(),
            'title' => fake()->sentence(),
        ];
    }
}
