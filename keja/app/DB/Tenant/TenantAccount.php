<?php

namespace App\DB\Tenant;

use App\DB\Building\Room;
use App\DB\Tenant;
use Illuminate\Database\Eloquent\Model;

class TenantAccount extends Model
{
    protected $guarded = [];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class,'tenant_id','id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class,'room_id','id');
    }

    public function tenantAccountItems()
    {
        return $this->hasMany(TenantAccountItem::class,'tenant_account_id','id');
    }



    public function getAmountAttribute()
    {

        return  $this->attributes['amount'] =  $this->total();

    }


    public function getUtilitiesAttribute()
    {

        return  $this->attributes['amount'] =  $this->total();

    }

    public function total()
    {

        return $this->tenantAccountItems->where('item','rent')->sum('amount');

    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'] = "unpaid";

    }
    public function getTotalAmountAttribute()
    {
        return $this->attributes['total_amount'] =  $this->total();

    }

}
