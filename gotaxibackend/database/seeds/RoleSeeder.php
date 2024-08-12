<?php

use Illuminate\Database\Seeder;
use App\Traits\RoleTrait;
class RoleSeeder extends Seeder
{
    use RoleTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->storeRoles();
    }
}
