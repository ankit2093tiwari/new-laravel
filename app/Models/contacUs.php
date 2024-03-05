<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contacUs extends Model
{
    use HasFactory;
    protected $table = 'contacustables';
    protected $fillable = [
        'contact_header',
        'company_name',
        'address',
        'city_state_zip',
        'phone_number',
        'corp_email',
        'contact_image',
    ];
}

