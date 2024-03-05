<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class homePageCampNews_SpoPartner extends Model
{
    use HasFactory;
    protected $table='homepagecampspons';
    protected $fillable = [
        'view',
        'sectionName',
        'title',
        'news_artical',
        'media',
        'media_type',
        'youtube_status',
        'expire_date',
        'featuredItem',
        'active',
    ];
}
