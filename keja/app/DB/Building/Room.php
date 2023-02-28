<?php

namespace App\DB\Building;

use App\DB\Lease\Lease;
use Illuminate\Database\Eloquent\Model;
use Innox\Traits\IsMetable;

class Room extends Model
{
    protected $guarded = [];

    use  IsMetable;

    //protected $with = ['metable'];

    public $metableArray = [
        'room_type',
        'is_dynamic'
    ];
    protected $casts = [
        'is_vacant'  => 'boolean'
    ];
    protected $appends = [
        'status_name','tenant_name'
    ];

    public function getNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id','id');
    }
    public function utilities()
    {
        return $this->hasMany(RoomUtility::class, 'room_id','id');
    }
    public function lease()
    {
        return $this->hasOne(Lease::class, 'room_id','id')->where('is_active', true);
    }

    public function getStatusNameAttribute()
    {
        return  $this->attributes['status_name'] =  $this->is_vacant ?
            "<span class='badge badge-warning'>Vacant</span>" :
            "<span class='badge badge-primary'>Occupied</span>";
    }

    public function getTenantNameAttribute()
    {
        $tenant = isset($this->lease->tenant->id) ? "<a href='". route('tenant_view', ['tenant' => $this->lease->tenant->id])."'>{$this->lease->tenant->name    }</a>" : "--";

        return $this->attributes['tenant_name']  =   $tenant;

    }

    public function getDepositAttribute()
    {
        $deposit = 0;

        foreach ($this->utilities->where('utility_type','deposit') as $bill)
        {
            $deposit += floatval(str_replace(',','', $bill->amount));
        }

        return $this->attributes['deposit']  = $deposit  ;

    }

    public function getRentAttribute()
    {
        $rent = 0;

        foreach ($this->utilities->where('utility_type','rent') as $bill)
        {
            $rent +=  floatval(str_replace(',','', $bill->amount));
        }

        return $this->attributes['rent']  = $rent  ;

    }

    public function scopeActive($query)
    {
        return $query->where('is_vacant', true);
    }
}
