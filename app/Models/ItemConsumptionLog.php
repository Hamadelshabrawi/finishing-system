<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemConsumptionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_purchase_id',
        'quantity',
        'unit_price',
        'total_cost',
        'product_id',
        'notes',
        'unit_cost',
        'item_id'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'unit_cost' => 'decimal:2'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function itemPurchase()
    {
        return $this->belongsTo(ItemPurchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

 
}
