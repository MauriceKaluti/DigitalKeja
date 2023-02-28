<?php

namespace App\DB;

use App\DB\Lease\Invoice;
use App\DB\Lease\Lease;
use App\DB\Lease\Payment;
use App\DB\Tenant\TenantAccount;
use App\DB\Tenant\TenantAccountItem;
use Innox\Classes\Handlers\Model;
use Innox\Traits\IsKinable;

class Tenant extends Model
{
    protected $guarded = [];




    use IsKinable;

    public function getNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }


    public function getEmailAttribute($value)
    {
        return $this->attributes['email'] =  strtolower($value);
    }

    public function lease()
    {
        return $this->hasOne(Lease::class,'tenant_id','id')
            ->where('is_active', true)->with('room');

    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class,'tenant_id','id');

    }
    public function payments()
    {
        return $this->hasMany(Payment::class,'tenant_id','id');

    }
    public function accounts()
    {
        return $this->hasMany(TenantAccount::class,'tenant_id','id');

    }
    public function accountItems()
    {
        return $this->hasMany(TenantAccountItem::class,'tenant_id','id');

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


    public function getRoomNameAttribute()
    {

        return  $this->attributes['room_name'] =
            isset($this->lease->room->building->name)  ?
        "<span> <a href='". route('building_read', ['building' => $this->lease->room->building->id])."'>". $this->lease->room->building->name . ' / '. $this->lease->room->room_number."</a></span>" :
        "<span class='badge badge-primary'>No Room</span>";

    }

    public function getExpectedRent()
    {
        return $this->lease;
    }

    public function getTheBalance()
    {
        return $this->invoices->where('status', '!=', 'paid')->sum('amount');

    }

    public function getUnitNumber()
    {
        return isset($this->lease->room->building->name)
            ? $this->lease->room->building->name. ' '. $this->lease->room->room_number
            : "---";

    }


    public function modelToArray()
    {

        return [
            'name' => $this->name,
            'id_no' => $this->id_no,
            'phone' =>  $this->phone_number,
            'lease_agreement' =>  $this->lease_agreement,
            'email' => $this->email,
            'building' => $this->room_name,
            'id' => $this->id
        ];

    }
}
