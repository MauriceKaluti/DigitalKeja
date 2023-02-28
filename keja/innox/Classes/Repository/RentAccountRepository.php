<?php

namespace Innox\Classes\Repository;


use App\DB\Tenant;
use Carbon\Carbon;

class RentAccountRepository
{
    public static function monthlyGrouped(Tenant $tenant)
    {

        $monthly  = $tenant->accounts;

        $data = [];
        foreach ($monthly as $index => $item) {
            $paid =  $tenant->payments->where('tenant_account_id', $item->id)->sum('amount');
            $amount = $item->tenantAccountItems->sum('amount');
            $data[] = [
                'month' => Carbon::parse( $item->month)->format('Y-m'),
                'amount' =>  $amount,
                'paid'=> $paid,
                'utilities'=> $paid,
                'balance'=> $amount - $paid,
                'edit' => "<a class='label label-success' href='". route('tenant.pay.edit', ['tenant' => $tenant->id, 'account' => $item->id]) ."'>Edit</a>",
                'pay' => "<a  class='label label-warning' href='". route('tenant.pay', ['tenant' => $tenant->id, 'account' => $item->id]) ."'>Pay</a>"
            ];
        }
        return $data;
    }
}
