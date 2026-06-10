<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusicSetting extends Model
{
    protected $fillable = [
        'file_path',
        'is_active',
        'autoplay',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'autoplay' => 'boolean',
    ];
}
