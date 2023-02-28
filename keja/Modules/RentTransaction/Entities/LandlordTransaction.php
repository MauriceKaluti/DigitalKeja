<?php

namespace Modules\RentTransaction\Entities;


use App\DB\Landlord\Landlord;
use Innox\Classes\Handlers\Model;

class LandlordTransaction extends Model
{
    public function landlord()
    {
        return $this->belongsTo(Landlord::class,'landlord_id','id');
    }

}
