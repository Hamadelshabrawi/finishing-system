<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\ProjectPhase;
use App\Models\ProjectFiles;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SystemLog;
use App\Models\FinalFinish;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'project_name',
        'contact_value',
        'execution_period',
        'delivery_date',
        'delivery_location',
        'client_id',
        'description',
        'technical_approval',
        'created_by'
    ];
    
    protected $dates = ['date', 'delivery_date'];

    protected $casts = [
        'date' => 'date',
        'delivery_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const APPROVAL_PENDING = 'pending';
    const APPROVAL_APPROVED = 'approved';
    const APPROVAL_NEED_MODIFY = 'need_modify';
    const APPROVAL_DISMISSED = 'dismissed';

    
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function initialFiles()
    {
        return $this->hasMany(ProjectFiles::class)->where('phase', 'initial');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all products associated with this project.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function technicalFiles()
    {
        return $this->hasMany(ProjectFiles::class)->where('phase', 'technical');
    }
    public function files(): HasMany
    {
        return $this->hasMany(ProjectFiles::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    public function contacts()
    {
        return $this->hasOne(ProjectContact::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function SystemLog()
    {
        return $this->hasOne(SystemLog::class , 'project_id', 'id');
    }

    public function outsources()
    {
        return $this->hasMany(Outsource::class);
    }


    public function getStatusAttribute()
    {
        if ($this->technical_approval === self::APPROVAL_NEED_MODIFY) {
            return 'need_modify';
        }
        
        if ($this->technical_approval === self::APPROVAL_DISMISSED) {
            return 'dismissed';
        }
        
        if ($this->technical_approval === self::APPROVAL_APPROVED) {
            return 'approved';
        }
        
        return 'pending';
    }

    public function getStatusBadgeAttribute()
    {
        $status = $this->status;
        $badgeClasses = [
            'approved' => 'badge badge-success',
            'partially_approved' => 'badge badge-info',
            'pending' => 'badge badge-warning',
            'rejected' => 'badge badge-danger',
        ];
        
        $statusLabels = [
            'approved' => 'Approved',
            'partially_approved' => 'Partially Approved',
            'pending' => 'Pending',
            'rejected' => 'Rejected',
        ];
        
        return '<span class="'.($badgeClasses[$status] ?? 'badge badge-secondary').'">'
            .($statusLabels[$status] ?? ucfirst($status))
            .'</span>';
    }
}