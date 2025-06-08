<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'item_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    /**
     * Get the product that owns the product item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the item that belongs to the product item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
