<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Item;
use App\Models\ProductItem;
use App\Models\Project;
use App\Models\Outsource;
use App\Models\GeneralNote;
use App\Models\FinalFinish;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'project_id',
    ];

    /**
     * Get all materials for this product
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Get the project that owns the product.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Get all items for this product
     */
    public function items(): HasMany
    {
        return $this->hasMany(ProductItem::class);
    }

    /**
     * Get all outsources for this product
     */
    public function outsources(): HasMany
    {
        return $this->hasMany(Outsource::class);
    }

    /**
     * Get all general notes for this product
     */
    public function generalNotes(): HasMany
    {
        return $this->hasMany(GeneralNote::class);
    }

    /**
     * Get all final finishes for this product
     */
    public function finalFinishes(): HasMany
    {
        return $this->hasMany(FinalFinish::class);
    }
}
