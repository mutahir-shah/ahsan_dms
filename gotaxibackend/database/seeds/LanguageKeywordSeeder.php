<?php

use App\Traits\LanguageKeywordTrait;
use Illuminate\Database\Seeder;

class LanguageKeywordSeeder extends Seeder
{
    use LanguageKeywordTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $this->storeLanguageKeywords();
    }
}
