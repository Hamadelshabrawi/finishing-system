<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;

class CheckProjectPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        $project = $request->route('project');
        
        if (auth()->user()->hasPermission($permission, $project)) {
            return $next($request);
        }
    
        abort(403, __('projects.unauthorized'));
    }
}
