<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'location',
        'contact',
        'description'
    ];

    /**
     * Get all outsources associated with this supplier
     */
    public function outsources()
    {
        return $this->hasMany(Outsource::class);
    }

}
