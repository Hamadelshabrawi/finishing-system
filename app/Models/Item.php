<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'price',
        'description',
        'total_stock',
        'current_cost',
        'total_cost',
        'total_quantity'
    ];

    protected $casts = [
        'total_cost' => 'decimal:2',
        'current_cost' => 'decimal:2',
        'price' => 'decimal:2'
    ];

    public function purchases()
    {
        return $this->hasMany(ItemPurchase::class);
    }

    public function consumptionLogs()
    {
        return $this->hasMany(ItemConsumptionLog::class, 'item_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
