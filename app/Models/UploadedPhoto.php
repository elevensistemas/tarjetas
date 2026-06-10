<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedPhoto extends Model
{
    protected $fillable = [
        'guest_name',
        'file_path',
        'comment',
        'status',
    ];
}
