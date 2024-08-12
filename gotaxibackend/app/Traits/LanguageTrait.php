<?php

namespace App\Traits;

use App\Language;
trait LanguageTrait
{

    public function storeLanguages()
    {
        $languages = $this->getLanguages();
        Language::truncate();
        Language::insert($languages);
    }

    public function getLanguages()
    {
        return [
            [
                'name' => 'English',
                'short_name' => 'en',
                'is_default' => 1
            ],
            [
                'name' => 'Romanian',
                'short_name' => 'ro',
                'is_default' => 0
            ],
            [
                'name' => 'Arabic',
                'short_name' => 'ar',
                'is_default' => 0
            ],
            [
                'name' => 'Swedish',
                'short_name' => 'swe',
                'is_default' => 0
            ],
            [
                'name' => 'Spanish',
                'short_name' => 'es',
                'is_default' => 0
            ],
            [
                'name' => 'French',
                'short_name' => 'fr',
                'is_default' => 0
            ],
            [
                'name' => 'Polish',
                'short_name' => 'pl',
                'is_default' => 0
            ],
            [
                'name' => 'Finnish',
                'short_name' => 'fi',
                'is_default' => 0
            ],
            [
                'name' => 'Somali',
                'short_name' => 'so',
                'is_default' => 0
            ],
            [
                'name' => 'Nepali',
                'short_name' => 'ne',
                'is_default' => 0
            ],
            [
                'name' => 'Swahili',
                'short_name' => 'sw',
                'is_default' => 0
            ],
            [
                'name' => 'Russian',
                'short_name' => 'ru',
                'is_default' => 0,
            ],
            [
                'name' => 'Chinese',
                'short_name' => 'zh',
                'is_default' => 0,
            ]
            // Russian
            // German
            // Chinease
            // Dutch
        ];
    }
}
