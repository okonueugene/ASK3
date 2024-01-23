<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Guard;
use App\Models\Patrol;
use App\Models\Site;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatrolHistory>
 */
class PatrolHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * 
     */

    protected $model = \App\Models\PatrolHistory::class;
    public function definition(): array
    {
        return [
            'patrol_id' => fake()->randomElement(\App\Models\Patrol::pluck('id')->toArray()),
            'guard_id' => fake()->randomElement(\App\Models\Guard::pluck('id')->toArray()),
            'site_id' => fake()->randomElement(\App\Models\Site::pluck('id')->toArray()),
            'company_id' => fake()->randomElement(\App\Models\Company::pluck('id')->toArray()),
            'date' => fake()->dateTimeBetween('-1 years', 'now'),
            'time' => fake()->time(),
            'tag_id' => fake()->randomElement(\App\Models\Tag::pluck('id')->toArray()),
            'status' => fake()->randomElement(['checked', 'missed','upcoming']),
            
        ];
    }
}
