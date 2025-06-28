<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {
        $availableLocales = ['en', 'ar'];
        
        if (!in_array($locale, $availableLocales)) {
            return redirect()->back();
        }

        App::setLocale($locale);
        session()->put('locale', $locale);
        
        // Redirect back to previous page with flash message
        return redirect()->back()->with('success', __('messages.language_changed'));
    }
}
