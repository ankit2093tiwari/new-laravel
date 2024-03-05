<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campaignPageModel extends Model
{
    use HasFactory;
    protected $table = 'campaignpagetables';
    protected $fillable = [
        'header',
        'media',
        'post',
    ];

}
