<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Growth extends Model
{
    protected $guarded = [];

    public function getValueAttributes($value)
    {
        return $this->attributes['value']  =  floatval($value);
    }
}
