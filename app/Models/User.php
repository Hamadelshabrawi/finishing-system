<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Permission;
use App\Models\Role;
use Spatie\Permission\Traits\HasRoles; 

class User extends Authenticatable
{
    use Notifiable, HasRoles;
    
    protected $fillable = ['name', 'email', 'password', 'type', 'role_id','profile_image'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Type-based Checks
    public function isAdmin() { return $this->type === 'admin'; }
    public function isStorekeeper() { return $this->type === 'storekeeper'; }
    public function isTechnical() { return $this->type === 'technical'; }
    public function isUser() { return $this->type === 'user'; }
    public function isFinancial() { return $this->type === 'financial'; }
    public function isOperationsManager() { return $this->type === 'operations_manager'; }

}


