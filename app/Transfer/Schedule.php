<?php

namespace App\Transfer;

use App\Supplier\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'amount',
        'reason',
        'supplier_id',
        'status',
        'start',
        'end',
        'frequency',
    ];


    public function setStartAttribute($value)
    {
        $this->attributes['start'] = Carbon::parse($value);
    }
    public function setEndAttribute($value)
    {
        $this->attributes['end'] = Carbon::parse($value);
    }

    public function getSchedules()
    {
        return $this->paginate();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
