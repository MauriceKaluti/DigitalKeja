<?php

namespace App\Business;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $guarded = [];

    public function uploadable()
    {
        return $this->morphTo();
    }
}
