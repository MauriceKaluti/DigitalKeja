<?php


namespace Innox\Classes\QueryFilter;

use Carbon\Carbon;
use Closure;

class DisburseDateBetweenFilter
{
    public function handle($request, Closure $next)
    {
        if ( ! request()->has('disburse_start_date') &&
            ! request()->has('disburse_end_date'))
        {
            return $next($request);

        }

        $builder =  $next($request);

        return $builder->whereBetween('disburse_at', [
            Carbon::parse(request('disburse_start_date'))->startOfDay() ,
            Carbon::parse(request('disburse_end_date'))->endOfDay()
        ]);
    }
}
