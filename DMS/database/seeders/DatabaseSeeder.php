<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            BranchSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            BusinessSeeder::class,
            RoleSeeder::class,
            EmploymentTypeSeeder::class,
            UserSeeder::class
        ]);
    }
}
