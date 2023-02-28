<?php


namespace Innox\Classes\QueryFilter;


class AccountIIdFilter
{
    public function handle($request, \Closure $next)
    {

        if (! request()->has('account_id'))
        {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('account_id', request('account_id'));
    }
}
