<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donationTracking extends Model
{
    use HasFactory;
    protected $table = 'donationtrackingtables';
    protected $fillable = [
        'what_ins_you_text',
        'gift_amt',
        'name',
        'phone_number',
        'email',
        'address',
        'gift_note',
    ];
}
