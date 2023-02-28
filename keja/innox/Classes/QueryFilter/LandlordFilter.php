<?php
namespace Innox\Classes\QueryFilter;

use Closure;

class LandlordFilter
{
    public function handle($request, Closure $next)
    {

        if ( ! request()->has('landlord_id') )
        {

            return $next($request);

        }
        $builder =  $next($request);


        return $builder->where('landlord_id', request('landlord_id'));
    }
}
