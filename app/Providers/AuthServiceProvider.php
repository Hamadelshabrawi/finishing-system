<?php

namespace App\Providers;

use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
        // Add other model-policy mappings here
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Skip permission registration if tables don't exist yet
        try {
            if (Schema::hasTable('permissions')) {
                foreach (Permission::all() as $permission) {
                    Gate::define($permission->name, function ($user) use ($permission) {
                        return $user->hasPermission($permission->name);

                    });
                }
            }
        } catch (\Exception $e) {
            // Tables don't exist yet
        }

        // Admin bypass
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}