<?php


namespace Innox\Classes\QueryFilter;


class TenantFilter
{

    public function handle($request, \Closure $next)
    {
        if (! request()->has('tenant_id'))
        {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('tenant_id', request('tenant_id'));
    }
}
