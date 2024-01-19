<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'user_type' => 'admin',
            'is_active' => true,
            'company_id' => 1
        ]);

        $guard = \App\Models\Guard::create([
            'company_id' => 1,
            'name' => 'Arnold Musembi',
            'email' => 'arnold@gmail.com',
            'phone' => '0711690636',
            'id_number' => '12345678',
            'password' => Hash::make('123456')
        ]);

    }
}
