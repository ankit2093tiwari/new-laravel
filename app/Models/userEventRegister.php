<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userEventRegister extends Model
{
    use HasFactory;
    protected $table = 'usereventregistertables';
    protected $fillable = [
        'event_id',
        'user_name',
        'user_email',
       'city',
       'state',
    ];

}
