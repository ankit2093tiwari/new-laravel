<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saveCommentsNewsEvent extends Model
{
    use HasFactory;
    protected $table = 'save_comments_news_event_table';
    protected $fillable = [
        'post_id',
        'sectionName',
        'name',
        'comment',
        'email_id',
        'status',

    ];
}
