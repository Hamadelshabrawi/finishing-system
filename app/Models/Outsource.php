<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outsource extends Model
{
    use HasFactory;
    
    protected $fillable = ['product_id', 'outsource_name', 'boarder_note', 'cost', 'quantity','project_id'];

    /**
     * Get the product that owns the outsource.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
