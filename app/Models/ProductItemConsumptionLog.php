<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItemConsumptionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_item_id',
        'total_quantity',
        'total_cost',
        'average_cost'
    ];

    protected $casts = [
        'total_cost' => 'decimal:2',
        'average_cost' => 'decimal:2'
    ];

    public function productItem()
    {
        return $this->belongsTo(ProductItem::class);
    }
}
