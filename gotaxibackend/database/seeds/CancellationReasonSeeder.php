<?php

use App\Traits\CancellationReasonTrait;
use Illuminate\Database\Seeder;

class CancellationReasonSeeder extends Seeder
{
    use CancellationReasonTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return $this->storeCancellationReasons();
    }
}
