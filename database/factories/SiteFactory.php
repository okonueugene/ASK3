<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Site::class;
    public function definition(): array
    {
        return [
            'company_id' => fake()->randomElement(\App\Models\Company::pluck('id')->toArray()),
            'name' => fake()->name(),
            'location' => fake()->address(),
            'lat' => fake()->latitude(),
            'long' => fake()->longitude(),
            'user_id' => fake()->randomElement(\App\Models\User::pluck('id')->toArray()),
            'timezone' => fake()->timezone(),
            'country' => fake()->country(),
        ];
    }
}
