<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Account;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Account\Entities\Repository\AccountRepository;
use Modules\Account\Http\Requests\AccountRequest;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $charts = ChartOfAccount::all();
        return view('account::index')->with(['charts'  => $charts]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

        if (! auth()->user()->can('create_chart'))
        {
            accessDenied();

            return  back();

        }

        $charts = ChartOfAccount::all();

        $parents = (new AccountRepository())->parents();

        return view('account::charts.create')->with([
            'charts'  => $charts,
            'parents'  => $parents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(AccountRequest $request)
    {
        $account = (new AccountRepository())->store();

        flash('successfully created a account')->success()->important();

        return  redirect(route('chart.show', ['chart'  => $account->chart->id]));
    }

    /**
     * Show the specified resource.
     *
     * @param ChartOfAccount $chart
     * @return Response
     */
    public function show(ChartOfAccount $chart)
    {
        $chart = $chart->load('accounts.parent.children');

        return view('account::charts.show')->with([
            'chart'  => $chart,
        ]);
    }

    public function showAccount(ChartOfAccount $chart , Account $account)
    {
        $chart = $chart->load('accounts.parent.children');
        $charts = ChartOfAccount::all();

        $parents = (new AccountRepository())->parents();

        return view('account::charts.account.show')->with([
            'chart'  => $chart,
            'account'  => $account,
            'charts'  => $charts,
            'parents'  => $parents,
            'parent'  => $account->parent
        ]);
    }

    public function updateAccount(AccountRequest $request ,  ChartOfAccount $chart , Account $account )
    {

        (new AccountRepository())->update($account);

        flash('successfully updated a account')->success()->important();

        return  redirect(route('chart.account.show', ['account' => $account->id , 'chart' => $chart->id]));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('account::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
