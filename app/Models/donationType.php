<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donationType extends Model
{
    use HasFactory;
    protected $table = 'donationtypetables';
    protected $fillable = [
        'zelle_text',
        'zelle_image',
        'cash_app_text',
        'cash_app_image',
        'mailing_text',
    ];
}
