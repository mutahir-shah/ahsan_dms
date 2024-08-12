<?php

use App\Traits\FaqTrait;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    use FaqTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->storeFaqs();
    }
}
