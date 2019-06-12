<?php

namespace App\Supplier;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'name',
        'number',
        'bank_code',
        'bank_name',
        'currency',
        'auth_code',
        'recipient_code',
        'primary'
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
}
