<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductNote extends Model
{
    protected $fillable = [
        'product_id',
        'note'
    ];

    protected $casts = [
        'note' => 'string'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
