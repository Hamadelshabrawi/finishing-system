<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSetting extends Model
{
    protected $fillable = [
        'project_id',
        'key',
        'name_en',
        'name_ar',
        'value',
        'description_en',
        'description_ar',
        'type',
        'is_required',
        'sort_order'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }
}
