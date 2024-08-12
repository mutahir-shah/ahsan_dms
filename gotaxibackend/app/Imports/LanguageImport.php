<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class LanguageImport implements
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $keyword = $row['keyword'];
            
            foreach ($row as $language => $translation) {
                if ($language !== 'keyword' && !empty($translation)) {
                    // Assume you have a way to map language columns to language IDs
                    $language_id = $this->getOrCreateLanguageId($language);
                    $keyword_id = $this->getKeywordId($keyword);

                    // Check if entry already exists
                    $existingEntry = DB::table('language_keyword')
                        ->where('language_id', $language_id)
                        ->where('keyword_id', $keyword_id)
                        ->exists();

                    // Insert only if entry does not already exist
                    if (!$existingEntry) {
                        DB::table('language_keyword')->insert([
                            'language_id' => $language_id,
                            'keyword_id' => $keyword_id,
                            'translation' => $translation,
                        ]);
                    }
                }
            }
        }
    }

    private function getOrCreateLanguageId($language)
    {
        if (!empty($language)) {
            // Try to get the language ID
            $language_id = DB::table('languages')->where('name', $language)->value('id');
            
            // If the language doesn't exist, create it and get the new ID
            if (!$language_id) {
                $language_id = DB::table('languages')->insertGetId(['name' => $language]);
            }

            return $language_id;
        }

        return null; // Return null if language name is empty or null
    }

    private function getKeywordId($keyword)
    {
        // Implement logic to get keyword ID by keyword name
        // Example: if your keywords table has a 'name' column
        return DB::table('keywords')->where('name', $keyword)->value('id');
    }
}
