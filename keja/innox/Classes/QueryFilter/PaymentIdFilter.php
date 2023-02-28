<?php


namespace Innox\Classes\QueryFilter;


class PaymentIdFilter
{
    public function handle($request, \Closure $next)
    {

        if (! request()->has('payment_id'))
        {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('payment_id', request('payment_id'));
    }
}
