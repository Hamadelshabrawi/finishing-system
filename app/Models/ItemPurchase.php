<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPurchase extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'purchase_price', 'quantity', 'remaining_quantity', 'purchase_date'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
