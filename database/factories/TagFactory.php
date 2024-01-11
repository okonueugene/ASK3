<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Site;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Tag::class;
    public function definition(): array
    {
        return [
            'code' => fake()->randomNumber(8),
            'site_id' => fake()->randomElement(\App\Models\Site::pluck('id')->toArray()),
            'company_id' => fake()->randomElement(\App\Models\Company::pluck('id')->toArray()),
            'name' => fake()->name(),
            'type' => fake()->randomElement(['QR', 'NFC']),
            'location' => fake()->address(),
            'lat' => fake()->latitude(),
            'long' => fake()->longitude(),

        ];
    }
}
