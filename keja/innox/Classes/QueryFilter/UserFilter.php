<?php


namespace Innox\Classes\QueryFilter;


class UserFilter
{
    public function handle($request, \Closure $next)
    {

        if (! request()->has('user_id'))
        {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('user_id', request('user_id'));
    }
}
