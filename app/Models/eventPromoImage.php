<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventPromoImage extends Model
{
    use HasFactory;
    protected $table = 'eventpromoimagetables';
    protected $fillable =[
        'hits',
        'event_title',
        'event_media',
        'media_type',
        'youtube_status',
        'active',

    ];
}
