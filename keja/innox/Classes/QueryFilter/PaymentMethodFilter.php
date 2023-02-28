<?php
namespace Innox\Classes\QueryFilter;

use Closure;

class PaymentMethodFilter
{
    public function handle($request, Closure $next)
    {
        $builder =  $next($request);

        if (! request()->has('payment_method'))
        {
            return $builder;

        }

        return $builder->where('payment_method', ucfirst(request('payment_method')));
    }
}
