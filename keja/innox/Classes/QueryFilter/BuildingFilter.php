<?php
namespace Innox\Classes\QueryFilter;

use Closure;

class BuildingFilter
{
    public function handle($request, Closure $next)
    {

        if ( ! request()->has('building_id') )
        {

            return $next($request);

        }
        $builder =  $next($request);


        return $builder->where('building_id', request('building_id'));
    }
}
