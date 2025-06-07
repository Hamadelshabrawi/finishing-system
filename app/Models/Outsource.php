<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outsource extends Model
{
    use HasFactory;
    
    protected $fillable = ['project_id','outsource_name','boarder_note','cost','quantity'];

}
