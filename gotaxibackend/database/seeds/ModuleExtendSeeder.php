<?php

use App\Traits\ModuleExtendTrait;
use Illuminate\Database\Seeder;

class ModuleExtendSeeder extends Seeder
{
    use ModuleExtendTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->storeModulesExtended();
    }
}
