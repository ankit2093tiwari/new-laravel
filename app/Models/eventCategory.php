<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventCategory extends Model
{
    use HasFactory;
    protected $table = 'eventcategorytables';
    protected $fillable = [
        'event_category',
        'event_description',
        'active',
    ];
}
