<?php

namespace App\DB\Lease;

use App\Business\Upload;
use App\User;
use Innox\Classes\Handlers\Model;
use Modules\Account\Entities\Journal;

class Payment extends Model
{
    protected $guarded = [];


    public function lease()
    {
        return $this->belongsTo(Lease::class,'lease_id','id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class ,'payment_id','id');
    }

    // over write upload

    public function uploadable()
    {
        return $this->morphOne(Upload::class, 'uploadable');

    }

    public function save(array $options = [])
    {
        if ( is_null($this->user_id))
        {
            $this->user_id = auth()->id();
        }
        parent::save();
    }
}
