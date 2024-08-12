<?php

use App\Traits\PageContentTrait;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    use PageContentTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->storePageContent();
    }
}
