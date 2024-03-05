<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class learnMoreSignUp extends Model
{
    use HasFactory;
    protected $table = 'learnmoresignuptables';
    protected $fillable = [
        'section_name',
       'name',
       'email',
       'phone',
       'interest',
       'message',
       'city',
       'state',
    ];
}
