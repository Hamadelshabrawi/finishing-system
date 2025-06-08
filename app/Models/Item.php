<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit', 'price', 'description'];

    public function purchases()
    {
        return $this->hasMany(ItemPurchase::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
