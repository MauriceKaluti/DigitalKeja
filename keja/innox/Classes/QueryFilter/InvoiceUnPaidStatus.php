<?php
namespace Innox\Classes\QueryFilter;

use Closure;

class InvoiceUnPaidStatus
{
    public function handle($request, Closure $next)
    {
        $builder =  $next($request);

        if (! request()->has('status'))
        {
            return $builder;

        }
        return $builder->where('status', '!=', 'paid');

    }
}
