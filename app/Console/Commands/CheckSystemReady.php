<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;

class CheckSystemReady extends Command
{
    protected $signature = 'system:check';
    protected $description = 'Check if system is properly configured';

    public function handle()
    {
        $requiredRoles = ['admin', 'manager', 'technical', 'client'];
        
        foreach ($requiredRoles as $role) {
            if (!Role::where('name', $role)->exists()) {
                $this->error("Missing role: {$role}");
                return 1;
            }
        }
        
        $this->info("All required roles exist");
        return 0;
    }
}