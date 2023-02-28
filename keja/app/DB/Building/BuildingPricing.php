<?php

namespace App\DB\Building;

use Illuminate\Database\Eloquent\Model;

class BuildingPricing extends Model
{
    protected $guarded = [];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public static function getPrice($buildingId ,$unityType, $utility , $utilityType , $amount = 0)
    {
        $price = self::where([
            'building_id'  => $buildingId,
            'unit_type'    => $unityType,
            'utility_type'  => $utilityType,
            'utility'      => $utility
        ])->first();

        if ( is_null($price))
        {
            return $amount;
        }
        return $price->amount;
    }

    public function pricingToArray()
    {
        return  [
            'utility'   => $this->utility,
            'utility_type'   => $this->utility_type,
            'unit_type'   => $this->unit_type,
            'building_id'   => $this->building_id,
        ];

    }
}
