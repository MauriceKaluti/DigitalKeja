<?php

namespace App\DB\Payment;

use App\DB\Landlord\Landlord;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Disburse extends Model
{
    protected $guarded = [];


    public function landlord()
    {
        return $this->belongsTo(Landlord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
