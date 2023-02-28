<?php


namespace Modules\Account\Entities\Repository;


use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\AccountIIdFilter;
use Innox\Classes\QueryFilter\ChartIdFilter;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\PaymentIdFilter;
use Modules\Account\Entities\Account;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Account\Entities\Journal;

class AccountRepository
{

    public function all()
    {
        return app(Pipeline::class)
            ->send(Account::query())
            ->through([
                IdFilter::class,
                ChartIdFilter::class,
                DateBetweenFilter::class
            ])
            ->thenReturn()
            ->with('chart')
            ->get();
    }

    public function parents()
    {

        return Account::where('has_children', true)->get();
    }

    public function store()
    {
        return Account::create([
            'name'  => request('name'),
            'chart_id'  => request('chart_id'),
            'allow_manual_entry'  => request()->has('allow_manual_entry') ? true : false,
            'has_children'  => request()->has('has_children') ? true : false,
            'description'  => request('description'),
            'glcode'  => request('glcode'),
            'parent_id'  =>  request('parent_id'),
        ]);
    }
    public function update(Account $account)
    {

        return $account->update([
            'name'  => request('name'),
            'chart_id'  => request('chart_id'),
            'allow_manual_entry'  => request()->has('allow_manual_entry') ? true : false,
            'has_children'  => request()->has('has_children') ? true : false,
            'description'  => request('description'),
            'glcode'  => request('glcode'),
            'parent_id'  => request()->has('parent_id') ? request('parent_id'): null,
        ]);
    }

    public function findByCode($glcode) : Account
    {

        return Account::where('glcode', $glcode)->firstOrFail();
    }


}
