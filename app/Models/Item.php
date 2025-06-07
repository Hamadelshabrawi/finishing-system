<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'unit', 'selling_price', 'total_stock'];

    public function purchases()
    {
        return $this->hasMany(ItemPurchase::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    
}
