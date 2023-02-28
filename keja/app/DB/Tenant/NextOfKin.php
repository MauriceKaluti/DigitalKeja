<?php

namespace App\DB\Tenant;

use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{

    protected $guarded = [];


    public function getNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function kinable()
    {
        return $this->morphTo();
    }
}
