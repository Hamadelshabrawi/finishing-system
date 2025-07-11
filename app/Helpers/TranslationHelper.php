<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Facades\App;

class TranslationHelper
{
    public static function translate($key)
    {
        $locale = App::getLocale();
        $translation = Translation::where('key', $key)->first();
        
        if (!$translation) {
            return $key;
        }
        
        if ($locale == 'ar') {
            return $translation->value_ar;
        }
        
        return $translation->value_en;
    }
}
