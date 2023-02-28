<?php

namespace App\DB;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $guarded = [];

    public function metable()
    {
        return $this->morphTo();
    }
}
