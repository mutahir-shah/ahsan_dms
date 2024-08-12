<?php

use App\AppLinks;
use App\CMS;
use App\Keyword;
use App\Language;
use App\SocialLink;
use Illuminate\Support\Facades\DB;
use anlutro\LaravelSettings\Facade as Setting;


function getServicesList()
{
    return collect([
        [   
            'name' => 'economy',
            'title' => 'Transportation'
        ],  
        [   
            'name' => 'economy',
            'title' => 'Transportation'
        ],  
        [   
            'name' => 'luxury',
            'title' => 'Delivery'
        ],  
        [   
            'name' => 'extra_seat',
            'title' => 'Town Truck'
        ],  
        [   
            'name' => 'outstation',
            'title' => 'Out Station'
        ],  
        [   
            'name' => 'dream_driver',
            'title' => 'Dream Driver'
        ],  
        [   
            'name' => 'road_assistance',
            'title' => 'Road Assistance'
        ],
    ]);
}


function getDefaultNames(){
    // Getting First Name Keys
    $firstLanguage = getLanguages()->first();
    $firstLanguageNameKey = 'name_' . $firstLanguage->id;
    $firstLanguageDescriptionKey = 'description_' . $firstLanguage->id;
    return [$firstLanguageNameKey, $firstLanguageDescriptionKey];
}

function storeMultipleDataRecords($request, $model){
    foreach (getLanguages() as $language) {
        $nameKey = 'name_' . $language->id;
        $descriptionKey = 'description_' . $language->id;

        $name = $request->has($nameKey) ? $request->{$nameKey} : null;
        $description = $request->has($descriptionKey) ? $request->{$descriptionKey} : null;

        $existingTranslation = $model->translations()->where('language_id', $language->id)
            ->where('name', $name)
            ->first();

        if ($existingTranslation) {
            // Handle the uniqueness error, e.g., throw an exception or set an error message
            return redirect()->back()->withErrors(['name_' . $language->name => 'The name must be unique.']);
        }

        if ($name || $description) {
            $translation = $model->translations()->firstOrNew([
                'language_id' => $language->id,
            ]);

            $translation->name = $name;
            $translation->description = $description;
            $translation->save();
        }
    }
}

function storeFile($file){
    $image = $file->store('website');
    $image = asset('storage/' . $image);
    return $image;
}

function getSettings($value){
    return Setting::get($value);
}

function getDefautlLanguage()
{
    return Language::where('is_default', 1)->pluck('id')->first();
}

function getLanguageIdFromApis($request)
{
    $lang = isset($request->lang) ? $request->lang : 'en';
    $defaultLangauge =  getDefautlLanguage();
    $otherLanguage =  Language::where('short_name', $lang)->first();
    $language_id = !is_null($otherLanguage) ? $otherLanguage->id : $defaultLangauge;
    return $language_id;
}


function getTranslationByLanguageId($languageId, $keywordId)
{
    return DB::table('language_keyword')->where([
        'language_id' => $languageId,
        'keyword_id' => $keywordId
    ])->first();
}

function translateKeyword($keyword)
{
    // Get the current language ID from session
    $languageId = session('translation');

    // Get the keyword ID for the provided keyword
    $keywordId = Keyword::where('name', $keyword)->value('id');

    if (!$keywordId) {
        return $keyword; // Return the original keyword if not found
    }

    // Retrieve the translation from the database
    $translation = DB::table('language_keyword')
        ->where('language_id', $languageId)
        ->where('keyword_id', $keywordId)
        ->value('translation');

    return $translation ?: $keyword; // Return translation or original keyword
}

function translateKeywordMobile($keyword, $languageId)
{
    // Get the keyword ID for the provided keyword
    $keywordId = Keyword::where('name', $keyword)->value('id');

    if (!$keywordId) {
        return $keyword;
    }


    $translation = DB::table('language_keyword')
        ->where('language_id', $languageId)
        ->where('keyword_id', $keywordId)
        ->value('translation');

    return $translation ?: $keyword;
}

function translateKeywordApis($keyword, $request)
{
    $languageId = getLanguageIdFromApis($request);
    // Get the keyword ID for the provided keyword
    $keywordId = Keyword::where('name', $keyword)->value('id');

    if (!$keywordId) {
        return $keyword;
    }


    $translation = DB::table('language_keyword')
        ->where('language_id', $languageId)
        ->where('keyword_id', $keywordId)
        ->value('translation');

    return $translation ?: $keyword;
}


function checkAndTranslateKeyword($keyword, $request)
{
    if (isset($request)) {
        return translateKeywordApis($keyword, $request);
    }
    return translateKeyword($keyword);
}

function getLanguages()
{
    $languages = Language::where('status', 'Active')->get();
    return $languages;
}

function getWebContent()
{
    $webContent = CMS::where('language_id', session()->get('translation'))->first();
    return $webContent;
}

function getColor()
{
    return Setting::get('site_color');
}

function getSocialLinks()
{
    $socialLinks = SocialLink::first();

    return $socialLinks;
}

function getAppLinks()
{
    $applinks = AppLinks::first();

    return $applinks;
}

function getOnboardingsforEdit($translation, $onboarding, $index)
{
    $isFirst = $index === 0;
    $title = $isFirst ? $onboarding->title : ($translation ? $translation->name : '');
    $description = $isFirst
        ? $onboarding->description
        : ($translation
            ? $translation->description
            : '');

    return [
        'title' => $title,
        'description' => $description
    ];
}
