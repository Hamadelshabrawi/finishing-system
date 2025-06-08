<?php

namespace App\Helpers;

class UserHelper
{
    public static function isAdmin()
    {
        return auth()->check() && auth()->user()->user_type === 'admin';
    }
}
