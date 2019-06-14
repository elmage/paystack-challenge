<?php

namespace App\Transfer;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'customer_id',
        'type',
        'bin',
        'last_4',
        'exp_month',
        'exp_year',
        'auth_code',
        'primary',
        'email'
    ];
}
