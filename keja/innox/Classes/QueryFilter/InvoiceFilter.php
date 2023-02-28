<?php


namespace Innox\Classes\QueryFilter;


class InvoiceFilter
{
    public function handle($request, \Closure $next)
    {

        if (! request()->has('invoice_id'))
        {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('invoice_id', request('invoice_id'));
    }
}
