<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Item;
use App\Models\ProductItem;
use App\Models\Project;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'project_id',
    ];

    /**
     * Get the project that owns the product.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    /**
     * Get the items associated with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'product_items')
                    ->using(ProductItem::class)
                    ->withTimestamps();
    }
}
