<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timezones = config('sitedata.timezones');

        foreach ($timezones as $timezone) {
            DB::table('timezones')->insert([
                'timezones' => $timezone,
            ]);
        }
    }
}
