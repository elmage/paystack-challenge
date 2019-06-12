<?php

namespace App\Supplier;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact_tel',
        'contact_name',
        'email'
    ];

    public function main_account() { return $this->hasOne(BankAccount::class)->where('primary',1); }
    public function accounts() { return $this->hasMany(BankAccount::class)->orderBy('primary','DESC'); }
}
