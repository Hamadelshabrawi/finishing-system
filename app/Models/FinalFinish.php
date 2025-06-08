<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalFinish extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'internal_paint', 'electrostatic', 'pvd', 'polishing'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
