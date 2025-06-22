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
        'unit_price',
        'total_price',
        'notes',
        'details'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'details' => 'array'
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
