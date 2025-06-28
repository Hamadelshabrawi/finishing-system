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
    public function items()
    {
        return $this->hasMany(ProductItem::class, 'product_id', 'id');
    }

    /**
     * Get all outsources for this product
     */
    public function outsources()
    {
        return $this->hasMany(Outsource::class);
    }

    public function ProductNote()
    {
        return $this->hasOne(ProductNote::class, 'product_id', 'id');
    }

    public function finalFinish()
    {
        return $this->hasOne(FinalFinish::class);
    }

    public function consumptions()
    {
        return $this->hasMany(ProductItemConsumption::class);
    }

    public function files()
    {
        return $this->hasMany(ProductFile::class);
    }
}
