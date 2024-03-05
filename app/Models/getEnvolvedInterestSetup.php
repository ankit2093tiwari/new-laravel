<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class getEnvolvedInterestSetup extends Model
{
    use HasFactory;
    protected $table = 'getenvolvedinterestsetuptables';
    protected $fillable = [
        'interest_type',
        'active',
    ];
}
