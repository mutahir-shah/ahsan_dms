<?php

use App\Enums\{Gender, MaritalStatus, Salutation};
use App\Models\{Module};
use Illuminate\Support\Facades\{Cache};

function translate($keyword): string
{
    return $keyword;
}

function getModules(){
    return Cache::remember('modules', 600, function(){
        return Module::with('modules')->orderBy('index', 'asc')->where('type', 1)->get();
    });
}

function getSalutations(){
    return Cache::rememberForever('salutations', function(){
        return Salutation::cases();
    });
}

function getMaritalStatuses(){
    return Cache::rememberForever('marital_statuses', function(){
        return MaritalStatus::cases();
    });
}

function getGenders(){
    return Cache::rememberForever('genders', function(){
        return Gender::cases();
    });
}
