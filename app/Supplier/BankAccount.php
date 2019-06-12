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

    public function getAccountForSupplier($id)
    {
        return $this->where('supplier_id',$id)->orderBy('primary','DESC')->get();
    }

    public function getAccountByRecipientCode($code) {
        return $this->with(['supplier'])->where('recipient_code', $code)->first();
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
}
