<?php


namespace Innox\Classes\QueryFilter;


class IdFilter
{
    public function handle($request, \Closure $next)
    {

        if (! request()->has('id'))
        {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('id', request('id'));
    }
}
