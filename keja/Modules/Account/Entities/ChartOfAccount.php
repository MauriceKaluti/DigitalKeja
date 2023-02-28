<?php

namespace Modules\Account\Entities;


use Innox\Classes\Handlers\Model;

class ChartOfAccount extends Model
{
    protected $guarded = [];


    public function accounts()
    {
        return $this->hasMany(Account::class, 'chart_id','id');
    }
    public function firstLevelChildren()
    {
        return $this->accounts()
            ->where('has_children', true)
            ->where('parent_id', null);
    }
}
