<?php

namespace App\DB\Payment;

use Illuminate\Database\Eloquent\Model;

class MpesaTransaction extends Model
{
    protected $guarded = [];

    protected $appends = [
        'full_name'
    ];

    public function  getFullNameAttribute()
    {
        return $this->attributes['full_name'] = $this->fullName();
    }
    public function  getTransAmountAttribute($value)
    {
        return $this->attributes['Trans_amount'] = floatval(str_replace(",","", $value));
    }

    public function fullName()
    {
        return $this->first_name .' '. $this->middle_name .' '. $this->last_name;
    }

}
