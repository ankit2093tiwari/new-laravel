<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campaignPageEquityManagement extends Model
{
    use HasFactory;
    protected $table = 'campaignpagetables';
    protected $fillable =[
        'hits',
        'sec_name',
        'description',
        'media_type',
        'media',
    ];
}
