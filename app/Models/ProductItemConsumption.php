<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItemConsumption extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'item_id',
        'quantity',
        'unit_cost',
        'total_cost',
        'notes',
        'consumption_details'
    ];

    protected $casts = [
        'total_cost' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'consumption_details' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
