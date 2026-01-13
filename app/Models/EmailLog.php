<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'recipients',
        'subject',
        'content',
        'status',
        'error',
        'attachments'
    ];

    protected $casts = [
        'recipients' => 'array',
        'attachments' => 'array'
    ];
}