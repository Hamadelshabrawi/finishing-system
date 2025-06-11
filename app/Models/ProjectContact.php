<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectContact extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'position',
        'phone_number',
        'email',
        'department'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
