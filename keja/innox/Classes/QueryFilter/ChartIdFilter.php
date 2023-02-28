<?php


namespace Innox\Classes\QueryFilter;


class ChartIdFilter
{
    public function handle($request, \Closure $next)
    {

        if (! request()->has('chart_id'))
        {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('chart_id', request('chart_id'));
    }
}
