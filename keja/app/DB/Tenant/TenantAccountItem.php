<?php

namespace App\DB\Tenant;

use Illuminate\Database\Eloquent\Model;

class TenantAccountItem extends Model
{
    protected $guarded = [];

    public function tenantAccount()
    {
        return $this->belongsTo(TenantAccount::class);
    }
}
