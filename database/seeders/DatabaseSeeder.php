<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\CompanySeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CompanySeeder::class,
            UserSeeder::class,

            // PermissionSeeder::class,
            // RoleSeeder::class,
            // PermissionRoleSeeder::class,
            // RoleUserSeeder::class,
        ]);

        \App\Models\User::factory(100)->create();
        \App\Models\Site::factory(30)->create();
        \App\Models\Guard::factory(200)->create();
        \App\Models\Tag::factory(100)->create();
    }
}
