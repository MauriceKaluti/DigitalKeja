<?php

namespace App;
 

use Illuminate\Database\Eloquent\Model;

class BuildingExpense extends Model
{
    //

    protected $fillable=['building_id','landlord_id','overseer','expense_particular','expense_amount'];

  
   
}
