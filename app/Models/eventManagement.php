<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventManagement extends Model
{
    use HasFactory;
    protected $table = 'eventmanagementtables';
    protected $fillable = [
        'hits',
        'event_title',
        'event_description',
        'date',
        'time',
        'event_type',
        'location_address',
        'city',
        'state',
        'zip_code',
        'event_media',
        'media_type',
        'youtube_status',
        'event_cost',
        'active',
        'notice',
    ];
}
