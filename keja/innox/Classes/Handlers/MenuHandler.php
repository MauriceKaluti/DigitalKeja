<?php


namespace Innox\Classes\Handlers;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuHandler implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if (isset($item['permission']))
        {
            if ($item['permission'] == 'landlord_browser')
            {
                dd('closer');
            }
        }

        if (isset($item['permission']) && ! auth()->user()->can($item['permission'])) {
            return false;
        }

        return $item;
    }
}
