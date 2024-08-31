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
            CountrySeeder::class,
            LanguageSeeder::class,
            BranchSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            BusinessSeeder::class,
            ModuleSeeder::class,
            RoleSeeder::class,
            EmploymentTypeSeeder::class,
            UserSeeder::class,
        ]);

    }
}
