<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [];


    protected $casts = [
        'allow_manual_entry'  => 'boolean',
        'has_children'  => 'boolean'
    ];
    public function parent()
    {
        return $this->belongsTo(Account::class,'parent_id','id');
    }

    public function chart()
    {
        return $this->belongsTo(ChartOfAccount::class,'chart_id','id');
    }
    public function children()
    {
        return $this->hasMany(Account::class,'parent_id','id');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class,'account_id','id');

    }

    public function getNameAttribute($value)
    {
        return $this->attributes['name']  = ucwords(strtolower($value));
    }
}
