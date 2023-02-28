<?php
namespace Innox\Classes\QueryFilter;

use Closure;

class PaymentStatusFilter
{
    public function handle($request, Closure $next)
    {
        $builder =  $next($request);

        if (! request()->has('payment_status'))
        {
            return $builder;

        }

        return $builder->where('status', request('payment_status'));
    }
}
