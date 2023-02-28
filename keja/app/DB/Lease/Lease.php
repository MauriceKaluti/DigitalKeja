<?php

namespace App\DB\Lease;

use App\DB\Building\Building;
use App\DB\Building\Room;
use App\DB\Tenant;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    protected $guarded = [];


    protected $with = ['room','tenant'];

    public static  function boot()
    {
        parent::boot();

        self::addGlobalScope(function ($query) {
           return $query->where('is_active', true)->where('tenant_id', '!=', 'null');
        });
    }
    public function invoice()
    {
        return $this->hasMany(Invoice::class,'lease_id','id')->where('status', '!=', 'paid');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'lease_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function room()
    {
        return $this->belongsTo(Room::class)->with('building');

    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class,'tenant_id','id') ;

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
}
