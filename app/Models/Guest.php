<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'assistants_count',
        'is_attending',
        'dietary_restrictions',
        'comments',
    ];

    protected $casts = [
        'is_attending' => 'boolean',
        'assistants_count' => 'integer',
    ];
}
