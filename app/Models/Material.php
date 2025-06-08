<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'item_id',
        'quantity',
        'notes',
        'source',
        'approval_status'
    ];

    const SOURCE_INVENTORY = 'inventory';
    const SOURCE_MANUAL = 'manual';

    const APPROVAL_PENDING = 'pending';
    const APPROVAL_APPROVED = 'approved';
    const APPROVAL_REJECTED = 'rejected';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function approvalLog()
    {
        return $this->morphOne(ApprovalLog::class, 'approvable');
    }

    public function setSourceAttribute($value)
    {
        $this->attributes['source'] = $value;
    }

    public function setApprovalStatusAttribute($value)
    {
        $this->attributes['approval_status'] = $value;
    }

    public function isManual()
    {
        return $this->source === self::SOURCE_MANUAL;
    }

    public function isInventory()
    {
        return $this->source === self::SOURCE_INVENTORY;
    }

    public function scopePendingManual($query)
    {
        return $query->where('source', self::SOURCE_MANUAL)
                     ->where('approval_status', self::APPROVAL_PENDING);
    }
    
}