<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralNote extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'Note'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
