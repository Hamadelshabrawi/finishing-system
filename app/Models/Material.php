<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'project_id',
        'item_id',
        'quantity',
        'notes',
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

    public function isManual()
    {
        return $this->material_source === self::SOURCE_MANUAL;
    }

    public function isInventory()
    {
        return $this->material_source === self::SOURCE_INVENTORY;
    }

    public function scopePendingManual($query)
    {
        return $query->where('material_source', self::SOURCE_MANUAL)
                     ->where('approval_status', self::APPROVAL_PENDING);
    }
    
}