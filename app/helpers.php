<?php

if (!function_exists('langAsset')) {
    function langAsset($path) {
        $lang = app()->getLocale();
        $assetPath = "Assets/{$lang}/" . ltrim($path, '/');
        
        if (!file_exists(public_path($assetPath)) && $lang !== 'en') {
            $assetPath = "Assets/en/" . ltrim($path, '/');
        }
        
        $version = file_exists(public_path($assetPath)) 
            ? filemtime(public_path($assetPath)) 
            : config('app.version');

        return asset($assetPath) . '?v=' . $version;
    }
}