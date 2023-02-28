<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    //
    protected $fillable=['title_id','drcr','account_title','description','dr_amt','cr_amt'];

}
