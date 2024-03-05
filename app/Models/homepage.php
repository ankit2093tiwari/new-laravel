<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class homepage extends Model
{
    use HasFactory;
    //protected $table = 'homepages';
    protected $fillable = [
        'page_name',
        'header_text',
        'mission_text',
        'page_text',
        'image',
        'image2',
        'image3',
        'impact_link',
        'section_title',
        'section_post',
        'section_media',
        'issue_link',
        'job_post_link',
        'promo_video',
        'youtube_status',
        'media_type_middle',
        'youtube_status_middle',
        'media_type_promo',
        'youtube_status_promo',
    ];

}
