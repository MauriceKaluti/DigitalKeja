<?php
namespace Innox\Classes\QueryFilter;

use Closure;

class ActiveFilter
{
    public function handle($request, Closure $next)
    {

        $builder =  $next($request);

        if (! request()->has('active'))
        {
            return $builder;

        }

        return $builder->where('is_active', request('active'));
    }
}
