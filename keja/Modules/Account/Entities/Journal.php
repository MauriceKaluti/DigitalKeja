<?php

namespace Modules\Account\Entities;

use App\DB\Lease\Payment;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journals';

    protected $guarded = [];


    public function account()
    {
        return $this->belongsTo(Account::class,'account_id','id');

    }

    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id','id');
    }
}
