<?php

use Illuminate\Database\Seeder;
use App\Traits\ModuleTrait;

class ModuleSeeder extends Seeder
{
    use ModuleTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->storeModules();
    }
}
