<?php

namespace App\DB\Lease;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $guarded = [];


    public function invoice()
    {
        return $this->belongsTo(Invoice::class ,'invoice_id','id');
    }

    public function setAmountAttribute($value)
    {
        return $this->attributes['amount'] = floatval(str_replace(',' ,'',$value));
    }
}
