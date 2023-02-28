<?php

namespace App\DB\Building;

use App\DB\Landlord\Landlord;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Innox\Traits\IsMetable;

class Building extends Model
{
    use IsMetable;

    protected $guarded = [];

    protected $fillable=['user_id','landlord_id','name','location','total_rooms','is_active','commission_rate'];


    public  $mettableArray = [
        'bills_inclusive',
        'commission_type',
        'commission_value',
    ];

    protected $appends = ['rent'];

    public function getNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }
    public function getTotalRoomsAttribute($value)
    {
        return $this->attributes['total_rooms'] = $this->rooms->count();
    }
    public function getRentAttribute($value)
    {
        return $this->attributes['rent'] = $this->expectedRent();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function landlord()
    {
        return $this->belongsTo(Landlord::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class)->with('utilities');
    }

 


    public function pricing()
    {
        return $this->hasMany(BuildingPricing::class)->with('building');
    }

    public function save(array $options = [])
    {
        $this->user_id = auth()->id();

        parent::save();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);

    }

    public function occupied()
    {

        $rooms = $this->rooms->count();

        if ($rooms < 1)
        {
            $rooms = 1;
        }

        $occupied = $this->rooms->where('is_vacant', false)->count();



        return  round(( 100 * $occupied) / $rooms ,0 , PHP_ROUND_HALF_EVEN);

    }

    public function getColorAttribute()
    {
        $color = 'label label-';
        if ($this->occupied() == 100) {

            $color .= 'success';

        }
        else{

            $color .='warning';
        }

        return $this->attributes['color'] = $color;

    }

    public function tenants()
    {
        $tenants = collect();

        foreach ($this->rooms as $room)
        {
            if ( isset($room->lease->tenant->id))
            {

                $tenants->push($room->lease->tenant);

            }

        }

        return $tenants;

    }


    public function expectedRent()
    {
        $amount = 0;

        foreach ($this->rooms as $room)
        {
            if ( isset($room->lease->tenant->id))
            {
                $amount += $room->rent;

            }

        }

        return $amount;

    }

    public function expectedDeposit()
    {
        $amount = 0;

        foreach ($this->rooms as $room)
        {
            if ( isset($room->lease->tenant->id))
            {
                $amount += $room->deposit;

            }

        }

        return $amount;

    }

    public function landlordFee()
    {
        $commission = 0;
        if ($this->getMeta('commission_type') === 'percentage')
        {
            $commission = ( (100 - floatval($this->getMeta('commission_value')) ) * $this->rent ) / 100;
        }
        if ($this->getMeta('commission_type') === 'fixed')
        {
            $commission =   $this->rent - floatval($this->getMeta('commission_value'));
        }

        return $commission;
    }
    public function manageCommission()
    {
        $commission = 0;
        if ($this->getMeta('commission_type') === 'percentage')
        {
            $commission =  (floatval($this->getMeta('commission_value'))  * $this->rent ) / 100;
        }

        if ($this->getMeta('commission_type') === 'fixed')
        {
            $commission =   floatval($this->getMeta('commission_value'));
        }

        return $commission;
    }
}
