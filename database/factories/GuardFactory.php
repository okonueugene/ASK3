<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GuardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Guard::class;
    public function definition(): array
    {
        return [
            'company_id' => fake()->randomElement(\App\Models\Company::pluck('id')->toArray()),
            'site_id' => fake()->randomElement(\App\Models\Site::pluck('id')->toArray()),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'id_number' => fake()->randomNumber(8),
            'is_active' => fake()->boolean(),
            'last_login_at' => fake()->dateTime(),
            'password' => Hash::make('password'),

        ];
    }
}
