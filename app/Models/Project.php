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

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'item_name',
        'project_name',
        'quantity',
        'execution_period',
        'delivery_date',
        'delivery_location',
        'client_id',
        'panel_number',
        'description',
        'print',
        'initial_approval',
        'technical_approval',
        'created_by'
    ];
    
    protected $dates = ['date', 'delivery_date'];

    const APPROVAL_PENDING = 'pending';
    const APPROVAL_APPROVED = 'approved';
    const APPROVAL_REJECTED = 'rejected';

    
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function initialFiles()
    {
        return $this->hasMany(ProjectFiles::class)->where('phase', 'initial');
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function finalFinish()
    {
        return $this->hasOne(FinalFinish::class);
    }


    public function outsources()
    {
        return $this->hasMany(Outsource::class);
    }

    public function generalNote()
    {
        return $this->hasOne(GeneralNote::class);
    }



}