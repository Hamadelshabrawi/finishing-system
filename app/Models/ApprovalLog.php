<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalLog extends Model
{
    protected $table = 'approval_logs';
    
    protected $fillable = [
        'project_id',
        'approval_type',
        'status',
        'notes',
        'approved_by'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
