<?php

namespace Modules\Account\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Account;
use Modules\Account\Entities\Repository\AccountRepository;
use Modules\Account\Entities\Repository\JournalRepository;
use Modules\Account\Http\Requests\JournalRequest;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

        $journals = collect();

        if ($request->has('account_id'))
        {
            $journals = (new JournalRepository())
                ->all()
                ->groupBy(function ($journal) {
                    return $journal->account->name;
                })
            ;
        }


        $accounts = (new AccountRepository())->all();

        return view('account::journals.index')
            ->with([
                'journals'  => $journals,
                'accounts'  => $accounts
            ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $accounts = (new AccountRepository())->all();
        return view('account::journals.create')->with(['accounts'  => $accounts]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(JournalRequest $request)
    {

        if ($request['debit_amount'] != $request['credit_amount'])
        {
            flash()->error('Amount does not balance')->important();

            return  back();
        }

        $debit = (new JournalRepository())
            ->create([
                'account_id' => $request['debit_account'],
                'debit' => 0,
                'credit' => $request['debit_amount'],
                'payment_id' => null,
                'narration' => $request['comment'],
                'created_at'  => Carbon::parse($request['transaction_date'])
            ]);

        $credit = (new JournalRepository())
            ->create([
                'account_id' => $request['credit_account'],
                'debit' =>   $request['credit_amount'],
                'credit' => 0,
                'payment_id' => null,
                'narration' => $request['comment'],
                'created_at'  => Carbon::parse($request['transaction_date'])
            ]);

        flash()->success('created a journal entry')->important();

        return  redirect()->route('chart.journal');
    }

    /**
     * Show the specified resource.
     * @param Account $account
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Account $account)
    {
        return view('account::journals.show')->with([
            'journals'  => $account->journals
        ]);
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
