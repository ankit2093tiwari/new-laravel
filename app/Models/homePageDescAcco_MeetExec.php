<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class homePageDescAcco_MeetExec extends Model
{
    use HasFactory;
    protected $table = 'homepagedescmeet';
    protected $fillable = [
        'sectionName',
        'column_1',
        'column_2',
        'description',
        'active',
        'media',
        'order_in_slider',
        'impactYear',
    ];
}
