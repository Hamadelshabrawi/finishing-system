<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalFinish extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'internal_paint', 
        'electrostatic',
        'pvd',
        'polishing'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
