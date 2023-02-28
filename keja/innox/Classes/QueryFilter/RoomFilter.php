<?php
namespace Innox\Classes\QueryFilter;

use Closure;

class RoomFilter
{
    public function handle($request, Closure $next)
    {

        if ( ! request()->has('room_id') )
        {

            return $next($request);

        }
        $builder =  $next($request);


        return $builder->where('room_id', request('room_id'));
    }
}
