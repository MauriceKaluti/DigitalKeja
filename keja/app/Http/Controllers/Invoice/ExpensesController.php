<?php

namespace App\Http\Controllers\Invoice;

use App\DB\Payment\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Innox\Classes\Repository\ExpensesRepository;

class ExpensesController extends Controller
{

    private $expenses;

    public function __construct()
    {
        $this->expenses = new ExpensesRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( ! $request->user()->can('expenses_payments')){
            accessDenied();
            return  back();
        }
        if ( ! isset($request['start_date']))
        {
            $request->request->add(['start_date' => Carbon::now()->startOfWeek()]);
        }
        if ( ! isset($request['end_date']))
        {
            $request->request->add(['end_date' => Carbon::now()->endOfWeek()]);
        }
        $expenses = $this->expenses->all();

        return view('payments.expenses.browse')->with([
            'expenses'   => $expenses
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ( ! $request->user()->can('expenses_payments')){
            accessDenied();
            return  back();
        }
        $expense = new Expense();

        return view('payments.expenses.create')->with([
            'expense' => $expense
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'type'   =>  'required',
            'note'  =>  'required'
        ]);

        $this->expenses->store($request);

        flash('Stored expenses successfully')
            ->success()
            ->important();
        return  redirect()
            ->route('payment_expenses');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request , Expense $expense)
    {
        if ( ! $request->user()->can('expenses_payments')){
            accessDenied();
            return  back();
        }

        return  view('payments.expenses.create')
            ->with([
                'expense'  => $expense
            ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $this->validate($request, [
            'amount' => 'required',
            'type'   =>  'required',
            'note'  =>  'required'
        ]);

        $this->expenses->update($request, $expense);

        flash('Updated updated successfully')
            ->success()
            ->important();
        return  redirect()
            ->route('payment_expenses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
