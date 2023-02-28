<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExternalIncome extends Model
{
    //

    protected $fillable=['building_id','landlord_id','overseer','income_particular','income_amount'];
   
}
