<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = \App\Models\Company::create([
            'company_name' => 'Optimum Group',
            'company_email' => 'info@optimumgroup.com',
            'status' => 1,
        ]);


    }
}
