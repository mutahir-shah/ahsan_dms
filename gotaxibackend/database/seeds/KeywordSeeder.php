<?php

use App\Traits\KeywordTrait;
use App\Traits\LanguageKeywordTrait;
use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    use KeywordTrait, LanguageKeywordTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->storeKeywords();
        $this->storeLanguageKeywords();
    }
}
