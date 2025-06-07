<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next, ...$types)
    {
        $user = Auth::user();
        
        if (!in_array($user->type, $types)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}