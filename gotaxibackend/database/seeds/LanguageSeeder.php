<?php

use Illuminate\Database\Seeder;
use App\Traits\LanguageTrait;
class LanguageSeeder extends Seeder
{
    use LanguageTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->storeLanguages();
    }
}
