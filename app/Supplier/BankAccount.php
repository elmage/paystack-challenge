<?php

namespace App\Supplier;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'number',
        'bank_code',
        'bank_name',
        'currency',
        'auth_code',
        'recipient_code',
        'primary'
    ];
}
