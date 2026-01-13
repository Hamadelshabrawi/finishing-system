<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'key',
        'value_en',
        'value_ar',
        'group',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getValueAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->value_ar : $this->value_en;
    }

    public static function getTranslation($key, $group = 'projects')
    {
        $translation = self::where('key', $key)
            ->where('group', $group)
            ->where('is_active', true)
            ->first();

        if ($translation) {
            return $translation->value;
        }

        // If not found in database, try to get from language files
        $locale = app()->getLocale();
        $file = resource_path("lang/{$locale}/{$group}.php");
        
        if (file_exists($file)) {
            $translations = require $file;
            
            if (isset($translations[$key])) {
                return $translations[$key];
            }
        }

        return $key; // Return the key if translation not found in both places
    }
}
