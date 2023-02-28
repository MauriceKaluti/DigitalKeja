<?php
namespace Innox\Classes\QueryFilter;

use Closure;

class VacantFilter
{
    public function handle($request, Closure $next)
    {
        $builder =  $next($request);

        if (! request()->has('vacant'))
        {
            return $builder;

        }

        return $builder->where('is_vacant', request('vacant'));
    }
}
