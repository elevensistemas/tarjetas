<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestMessage extends Model
{
    protected $fillable = [
        'guest_name',
        'message',
        'status',
    ];
}
