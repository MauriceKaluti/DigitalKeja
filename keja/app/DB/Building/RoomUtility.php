<?php

namespace App\DB\Building;

use Illuminate\Database\Eloquent\Model;

class RoomUtility extends Model
{
    protected $guarded = [];


    public function room()
    {
        return $this->belongsTo(Room::class ,'room_id','id');
    }

}
