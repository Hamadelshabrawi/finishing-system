<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->type, ['admin', 'manager', 'technical']);
    }

    public function view(User $user, Project $project)
    {
        // Admins and managers can view all projects
        if (in_array($user->type, ['admin', 'manager'])) {
            return true;
        }
        
        // Technical staff can view assigned projects
        if ($user->type === 'technical') {
            return $project->technical_staff_id === $user->id;
        }
        
        // Clients can view their own projects
        if ($user->type === 'client') {
            return $project->client_id === $user->id;
        }
        
        return false;
    }

    public function create(User $user)
    {
        return in_array($user->type, ['admin', 'manager', 'client']);
    }

    public function update(User $user, Project $project)
    {
        if (in_array($user->type, ['admin', 'manager'])) {
            return true;
        }
        
        if ($user->type === 'client') {
            return $project->client_id === $user->id;
        }
        
        return false;
    }

    public function delete(User $user, Project $project)
    {
        return $user->type === 'admin';
    }

    public function restore(User $user, Project $project)
    {
        return $user->type === 'admin';
    }

    public function forceDelete(User $user, Project $project)
    {
        return $user->type === 'admin';
    }
}