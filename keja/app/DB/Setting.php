<?php

namespace App\DB;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public static function add(array $args)
    {
        foreach ($args as $key => $arg) {

            self::updateOrCreate([
                'key' => $key,
            ],[
                'key' => $key,
                'value' => $arg
            ]);

        }
    }
}
