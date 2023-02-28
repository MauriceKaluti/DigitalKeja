<?php

namespace App\DB\Landlord;

use App\DB\Building\Building;
use App\DB\Payment\Disburse;
use Illuminate\Database\Eloquent\Model;
use Modules\RentTransaction\Entities\LandlordTransaction;

class Landlord extends Model
{
    protected $guarded = [];



    public function getNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function buildings()
    {
        return $this->hasMany(Building::class,'landlord_id','id')->where('is_active' , true);
    }

    public function disburses()
    {
        return $this->hasMany(Disburse::class,'landlord_id','id');
    }

    public function save(array  $options = [])
    {
        $this->user_id = auth()->id();

        parent::save();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function tenants()
    {
        $this->load('buildings.rooms.lease.tenant');

        $tenants = collect();
        foreach ($this->buildings as $building) {

            foreach ($building->rooms as $room) {

                if ( isset( $room->lease->tenant->id) && $room->lease->tenant->id)
                {
                    $tenants->push($room->lease->tenant);
                }
            }

        }
        return $tenants;
    }

    public function getCommissionString()
    {
        if (! empty(trim($this->commission_value)) )
        {

            if ($this->commission_type === 'dynamic'){
                return $this->commission_value .' %';
            }

            return $this->commission_value .' /=';
        }
        return "Not Set";
    }

    public function landlordTransactions()
    {
        return $this->hasMany(LandlordTransaction::class,'landlord_id','id');
    }


    public function modelToArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'id_no' => $this->id_no,
            'phone' => $this->phone_number,
            'email' => $this->email,
            'commission' => $this->getCommissionString(),
            'buildings' => '<a href="'. route('building_browse', ['landlord_id' => $this->id]).'">'.$this->buildings()->count().'</a>'
        ];
    }


}
