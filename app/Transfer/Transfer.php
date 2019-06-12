<?php

namespace App\Transfer;

use App\Supplier\BankAccount;
use App\Supplier\Supplier;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'supplier_id',
        'amount',
        'currency',
        'reason',
        'account_id',
        'transfer_code',
        'reference',
        'status'
    ];



    public function filter()
    {
        return $this
            ->latest()
            ->paginate(50);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function account()
    {
        return $this->belongsTo(BankAccount::class,'account_id');
    }

    public function generateRef($length)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        $string = 'twone_';

        for ($i = 0; $i <= $length; $i++) {
            $string .= $chars[rand(0, strlen($chars) - 1)];
        }

        if ($this->where('reference', $string)->exists()) { $this->generateRef($length+1); }

        return $string;
    }
}
