<?php


namespace Innox\Classes\QueryFilter;

use Carbon\Carbon;
use Closure;

class DateBetweenFilter
{
    public function handle($request, Closure $next)
    {
        if ( ! request()->has('start_date') && ! request()->has('end_date'))
        {
            return $next($request);

        }

        $builder =  $next($request);

        return $builder->whereBetween('created_at', [
            Carbon::parse(request('start_date'))->startOfDay() , Carbon::parse(request('end_date'))->endOfDay()
        ]);
    }
}
