<?php
namespace Innox\Classes\QueryFilter;

use Closure;

class ExpenseTypeFilter
{
    public function handle($request, Closure $next)
    {
        $builder =  $next($request);

        if (! request()->has('expense_type'))
        {
            return $builder;

        }

        return $builder->where('type', ucfirst(request('expense_type')));
    }
}
