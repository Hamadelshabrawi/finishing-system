<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'assigned_to',
        'name',
        'description',
        'status',
        'due_date',
        'assigned_at',
        'completed_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'assigned_at' => 'date',
        'completed_at' => 'date',
    ];

    /**
     * Get the project that owns the task
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user assigned to this task
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
