<?php

use App\Traits\OnboardingTrait;
use Illuminate\Database\Seeder;

class OnboardingSeeder extends Seeder
{
    use OnboardingTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->storeOnboardings();
    }
}
