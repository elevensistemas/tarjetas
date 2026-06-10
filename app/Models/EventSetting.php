<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSetting extends Model
{
    
    protected $fillable = [
        'quinceanera_name',
        'event_date',
        'event_place',
        'event_address',
        'google_maps_url',
        'google_maps_share_url',
        'dress_code',
        'dress_code_description',
        'hero_text',
        'hero_subtext',
        'quinceanera_message',
        'design_settings',
        'hero_image_path',
        'monogram_path',
        'whatsapp_phone',
        'whatsapp_message',
        'whatsapp_enabled',
        'gifts_alias',
        'gifts_cbu',
        'gifts_text',
        'gifts_qr_path',
        'gifts_enabled',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'design_settings' => 'array',
        'whatsapp_enabled' => 'boolean',
        'gifts_enabled' => 'boolean',
    ];
}
